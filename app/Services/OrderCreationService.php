<?php

namespace App\Services;

use App\Models\Metadata;
use App\Models\Order;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderCreationService
{
    public function createFromRequest(Request $request): Order
    {
        return DB::transaction(function () use ($request) {
            $details = $this->getSelectedDetails($request->input('order.details', []));

            $patient = Patient::find($request->input('patient.id')) ?? new Patient();
            $patient->fill($request->input('patient', []));
            $patient->save();

            $this->syncPatientMetadata($patient->id, [
                'role' => $request->input('patient.role'),
                'section' => $request->input('patient.section'),
                'address' => $request->input('patient.address'),
                'hierarchy' => $request->input('patient.hierarchy'),
            ]);

            $order = new Order(['order_number' => Order::generate_number()]);
            $order->patient()->associate($patient);
            $order->save();

            foreach ($details as $item) {
                $order->details()->create([
                    'item' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            $order->load(['patient', 'details']);

            return $order;
        });
    }

    private function getSelectedDetails(array $details): array
    {
        $selected = [];

        foreach ($details as $detail) {
            if (isset($detail['selected']) && boolval($detail['selected'])) {
                $selected[] = [
                    'name' => $detail['name'] ?? '',
                    'price' => floatval($detail['price'] ?? 0),
                    'quantity' => intval($detail['quantity'] ?? 0),
                ];
            }
        }

        return $selected;
    }

    private function syncPatientMetadata(int $patientId, array $metadata): void
    {
        foreach ($metadata as $key => $value) {
            Metadata::updateOrCreate(
                [
                    'meta_type' => 'patient',
                    'meta_id' => $patientId,
                    'meta_key' => $key,
                ],
                [
                    'meta_value' => $value,
                ]
            );
        }
    }
}
