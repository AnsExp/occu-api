<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderOptionRequest;
use App\Http\Requests\LaboratoryOrderRequest;
use App\Http\Services\LaboratoryOrderService;
use App\Models\LaboratoryOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaboratoryOrderController extends Controller
{
    public function __construct(private LaboratoryOrderService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = LaboratoryOrder::orderBy(
            request('sort', 'created_at'),
            request('direction', 'desc')
        )->paginate(10);
        return view('laboratory_order.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laboratory_order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryOrderRequest $request)
    {
        // return response()->json($request->all());
        $laboratoryOrder = $this->service->store($request);
        return redirect()->route('laboratory_orders.show', $laboratoryOrder);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaboratoryOrder $laboratoryOrder)
    {
        $filePath = $laboratoryOrder->file;
        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'PDF file not found.');
        }
        return response()->file(storage_path('app/private/' . $filePath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $laboratoryOrder->code . '.pdf"',
        ]);
    }

    public function updateOptions(OrderOptionRequest $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaboratoryOrder $order)
    {
        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaboratoryOrder $order)
    {
        abort(403, 'Unauthorized action.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaboratoryOrder $order)
    {
        abort(403, 'Unauthorized action.');
    }
}
