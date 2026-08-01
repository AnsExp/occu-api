<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\CertificateKey;
use App\Models\Order;
use Illuminate\Http\Request;
use Storage;

abstract class CertificateController extends Controller
{
    protected $type = null;

    public function orderByRequest(Request $request)
    {
        $order = null;
        if ($orderNumber = $request->input('order_number', false)) {
            $order = Order::findByOrderNumber($orderNumber);
            if (!$order) {
                session()->flash('warning', __('messages.order_not_found'));
            } elseif ($order->hasCertificateType($this->type)) {
                session()->flash('error', __('messages.certificate_exists', ['type' => __('messages.' . $this->type)]));
                $order = null;
            }
        } else {
            session()->flash('info', __('messages.enter_order_number', ['type' => __('messages.' . $this->type)]));
        }
        return $order;
    }

    public function certificateKeyByRequest(Request $request, Certificate $certificate)
    {
        $certificateKey = null;
        if ($certificateKeyValue = $request->input('certificate_key', false)) {
            $certificateKey = CertificateKey::findByKey($certificateKeyValue);
        }
        if (!($certificateKey?->isActive() ?? false)) {
            return null;
        }
        if ($certificateKey->certificate->id !== $certificate->id) {
            return null;
        }
        if ($certificateKey->authorizedUser->id !== auth()->user()->id) {
            return null;
        }
        return $certificateKey;
    }

    protected function getFilePath(Certificate $certificate)
    {
        $filePath = $certificate->file_path;
        if (!Storage::disk('local')->exists($filePath)) {
            return false;
        }
        return storage_path('app/private/' . $filePath);
    }
}
