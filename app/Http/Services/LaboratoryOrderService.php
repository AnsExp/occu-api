<?php

namespace App\Http\Services;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryOption;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryOrderService
{
    public function __construct(private DocumentService $documentService)
    {
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $person = PersonalData::find($request->input('person.id'));
            $patient = PatientService::preparePerson($person);

            $order = LaboratoryOrder::create([
                'code' => $this->generateCode(),
                'patient_id' => $patient->id,
                'doctor_id' => $request->input('doctor.id'),
                'timezone' => $request->input('timezone'),
            ]);

            foreach ($request->input('items', []) as $item) {
                $laboratoryOption = LaboratoryOption::find($item['option']);
                if (!$laboratoryOption) {
                    continue;
                }

                $exam = $order->laboratoryExams()->make([
                    'quantity' => $item['quantity'] ?? 1,
                    'price' => $laboratoryOption->price,
                    'name' => $laboratoryOption->name,
                ]);

                $exam->laboratoryOption()->associate($laboratoryOption);
                $exam->save();
            }

            $order->load('laboratoryExams.laboratoryOption');

            $filePath = 'laboratory_orders/' . $order->code . '.pdf';

            if ($this->storePdf($order, $filePath)) {

                $order->document()->create([
                    'timezone' => $request->input('timezone'),
                    'snapshot' => $request->all(),
                    'sha256' => occu_hash(occu_storage()->get($filePath)),
                    'file' => $filePath,
                ]);

                return $order;
            } else {
                throw new \Exception();
            }
        });
    }

    public function update(Request $request, LaboratoryOrder $order)
    {
        return DB::transaction(function () use ($request, $order) {
            return null;
        });
    }

    private function generateCode()
    {
        $offset = 0;
        do {
            $offset++;
            $lastOrder = LaboratoryOrder::withTrashed(true)->latest('id')->first();
            $code = 'LAB-' . Date('Ymd') . '-' . (($lastOrder?->id ?? 0) + 1 + $offset);
        } while (LaboratoryOrder::withTrashed(true)->where('code', $code)->exists());
        return $code;
    }

    private function storePdf(LaboratoryOrder $order, string $path)
    {
        return $this->documentService->store('documents.laboratory_order', ['order' => $order], $path);
    }
}
