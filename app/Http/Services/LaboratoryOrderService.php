<?php

namespace App\Http\Services;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryOption;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratoryOrderService
{
    // use DocumentService;

    // public function __construct(){
    //     $this->documentTemplate = 'documents.laboratory_order';
    //     $this->storageDiskPath = 'laboratory_orders';
    // }

    public function store(Request $request): LaboratoryOrder
    {
        return DB::transaction(function () use ($request) {
            $order = LaboratoryOrder::create([
                'code'       => $this->generateCode(),
                'patient_id' => $this->preparePatientId($request),
                'doctor_id'  => $request->input('doctor.id'),
                'timezone'   => $request->input('timezone'),
            ]);

            $this->syncExams($order, $request->input('items', []));
            // $this->createDocument($order, $request, true);

            return $order->load('laboratoryExams.laboratoryOption', 'documents');
        });
    }

    public function update(Request $request, LaboratoryOrder $order): LaboratoryOrder
    {
        return DB::transaction(function () use ($request, $order) {
            $order->update([
                'patient_id' => $this->preparePatientId($request),
                'doctor_id'  => $request->input('doctor.id'),
                'timezone'   => $request->input('timezone'),
            ]);

            $this->syncExams($order, $request->input('items', []));
            // $this->createDocument($order, $request, false);

            return $order->load('laboratoryExams.laboratoryOption', 'documents');
        });
    }

    private function preparePatientId(Request $request): int
    {
        $person  = PersonalData::findByIdCard($request->input('person.id_card'));
        $patient = PatientService::preparePatient($person);
        return $patient->id;
    }

    private function syncExams(LaboratoryOrder $order, array $items): void
    {
        $order->laboratoryExams()->delete();

        foreach ($items as $item) {
            if ($option = LaboratoryOption::find($item['id'])) {
                $order->laboratoryExams()->create([
                    'quantity'              => $item['quantity'] ?? 1,
                    'laboratory_option_id'  => $option->id,
                    'price'                 => $option->price,
                    'name'                  => $option->name,
                ]);
            }
        }
    }

    // private function createDocument(LaboratoryOrder $order, Request $request, bool $isNew): void
    // {
    //     $this->documentParams = compact('order');
    //     $this->persistPdf();

    //     $latest  = $order->documents()->latest('created_at')->first();
    //     $version = $isNew ? '1.0' : ($latest ? number_format(((float) $latest->version) + 0.1, 1) : '1.0');

    //     $order->documents()->create([
    //         'version'  => $version,
    //         'timezone' => $request->input('timezone'),
    //         'snapshot' => $request->all(),
    //         'sha256'   => occu_hash($this->content),
    //         'file'     => $this->filePath,
    //     ]);
    // }

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
