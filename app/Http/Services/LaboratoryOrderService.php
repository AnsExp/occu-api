<?php

namespace App\Http\Services;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryOption;
use App\Models\Patient;
use App\Models\Person;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaboratoryOrderService
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $person = Person::find($request->input('person.id'));
            $patient = Patient::where('person_id', $person->id)->first();

            if (!$patient) {
                $patient = $person->patient()->create();
            }

            $order = new LaboratoryOrder([
                'code' => LaboratoryOrder::generateCode(),
                'timezone' => $request->input('timezone'),
                'sign' => 'temp',
                'file' => 'temp',
            ]);

            $order->patient()->associate($patient);
            $order->save();

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
                $order->sign = occu_hash(Storage::disk('local')->get($order->file));
                $order->save();

                return $order;
            } else {
                throw new \Exception(json_encode($path));
            }
        });
    }

    private function storePdf(LaboratoryOrder $laboratoryOrder)
    {
        try {
            $pdf = Pdf::loadView('documents.laboratory_order', compact('laboratoryOrder'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('isRemoteEnabled', true);
            $filePath = 'laboratory_orders/' . $laboratoryOrder->code . '.pdf';
            $saved = Storage::disk('local')->put($filePath, $pdf->output());
            return $saved ? $filePath : false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
