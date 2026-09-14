<?php

namespace App\Http\Services;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryOption;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryOrderService
{

    public function store(Request $request): LaboratoryOrder
    {
        return DB::transaction(function () use ($request) {
            $order = LaboratoryOrder::create([
                'code' => $this->generateCode(),
                'patient_id' => $this->preparePatientId($request),
                'doctor_id' => $request->input('doctor.id'),
                'timezone' => $request->input('timezone'),
            ]);

            $this->syncExams($order, $request->input('items', []));

            return $order->load('laboratoryExams.laboratoryOption', 'documents');
        });
    }

    public function result(Request $request, LaboratoryOrder $order): LaboratoryOrder
    {
        return DB::transaction(function () use ($request, $order) {
            foreach ($request->file('files', []) as $file) {
                $path = 'laboratory_orders/' . $order->code . '-' . rand() . '.' . $file->getClientOriginalExtension();
                occu_storage()->put($path, $file->getContent());
                $order->documents()->create([
                    'timezone' => $request->input('timezone'),
                    'sha256' => occu_hash($file->getContent()),
                    'file' => $path,
                ]);
            }
            return $order;
        });
    }

    public function update(Request $request, LaboratoryOrder $order): LaboratoryOrder
    {
        return DB::transaction(function () use ($request, $order) {
            $order->update([
                'patient_id' => $this->preparePatientId($request),
                'doctor_id' => $request->input('doctor.id'),
                'timezone' => $request->input('timezone'),
            ]);

            $this->syncExams($order, $request->input('items', []));

            return $order->load('laboratoryExams.laboratoryOption', 'documents');
        });
    }

    private function preparePatientId(Request $request): int
    {
        $person = PersonalData::findByIdCard($request->input('person.id_card'));
        $patient = PatientService::preparePatient($person);
        return $patient->id;
    }

    private function syncExams(LaboratoryOrder $order, array $items): void
    {
        $order->laboratoryExams()->delete();

        foreach ($items as $item) {
            if ($option = LaboratoryOption::find($item['id'])) {
                $order->laboratoryExams()->create([
                    'quantity' => $item['quantity'] ?? 1,
                    'laboratory_option_id' => $option->id,
                    'price' => $option->price,
                    'name' => $option->name,
                ]);
            }
        }
    }

    private function generateCode(): string
    {
        $offset = 0;
        do {
            $offset++;
            $lastOrder = LaboratoryOrder::withTrashed()->latest('id')->first();
            $code = 'LAB-' . date('Ymd') . '-' . (($lastOrder?->id ?? 0) + $offset);
        } while (LaboratoryOrder::withTrashed()->where('code', $code)->exists());

        return $code;
    }
}
