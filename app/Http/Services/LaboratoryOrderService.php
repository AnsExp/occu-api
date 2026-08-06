<?php

namespace App\Http\Services;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryOption;
use App\Models\Person;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryOrderService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $person = Person::find($request->input('person.id'));
            $patient =  PatientService::preparePerson($person);

            $order = LaboratoryOrder::create([
                'patient_id' => $patient->id,
                'code' => $this->generateCode(),
                'timezone' => $request->input('timezone'),
                'sha256' => 'temp',
                'file' => 'temp',
                'snapshot' => $request->all(),
            ]);

            foreach ($request->input('items', []) as $item) {
                $laboratoryOption = LaboratoryOption::find($item['option']);
                if (!$laboratoryOption) {
                    continue;
                }

                $exam = $order->laboratoryExams()->make([
                    'quantity' => $item['quantity'] ?? 1,
                ]);

                $exam->laboratoryOption()->associate($laboratoryOption);
                $exam->save();
            }

            $order->load('laboratoryExams.laboratoryOption');

            if ($path = $this->storePdf($order)) {
                $order->file = $path;
                $order->sha256 = occu_hash(occu_storage()->get($order->file));
                $order->save();

                return $order;
            } else {
                throw new \Exception(json_encode($path));
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

    private function storePdf(LaboratoryOrder $order)
    {
        try {
            $pdf = Pdf::loadView('documents.laboratory_order', compact('order'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('isRemoteEnabled', true);
            $filePath = 'laboratory_orders/' . $order->code . '.pdf';
            $saved = occu_storage()->put($filePath, $pdf->output());
            return $saved ? $filePath : false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
