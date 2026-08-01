<?php

namespace App\Http\Controllers;

use App\Http\Requests\RadiologyRequest;
use App\Http\Services\CertificateSearchService;
use App\Http\Services\RadiologyService;
use App\Models\Certificate;
use App\Policies\CertificatePolicy;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class RadiologyController extends CertificateController
{
    protected $type = 'radiology';

    public function __construct(
        private CertificateSearchService $certificateSearchService,
        private RadiologyService $radiologyService,
        private CertificatePolicy $policy,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->policy->viewAny(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }
        $certificates = $this->certificateSearchService->search($this->type)->orderBy('created_at', 'desc')->paginate(10);
        return view('radiology.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!$this->policy->create(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }
        $order = $this->orderByRequest(request());
        return view('radiology.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RadiologyRequest $request)
    {
        if (!$this->policy->create(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }
        $radiology = $this->radiologyService->store($request);
        return redirect()->route('radiology.show', $radiology);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $radiology)
    {
        if (!$this->policy->view(auth()->user(), $radiology)) {
            abort(403, 'Unauthorized action.');
        }
        $filePath = $this->getFilePath($radiology);
        if (!$filePath) {
            abort(404, 'PDF file not found.');
        }
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $radiology->title . '.pdf"',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $radiology)
    {
        if (!$this->policy->update(auth()->user(), $radiology)) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $radiology)
    {
        if (!$this->policy->update(auth()->user(), $radiology)) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $radiology)
    {
        if (!$this->policy->delete(auth()->user(), $radiology)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function consent()
    {
        return PDF::loadView('documents.consent_xray')
            ->setPaper('A4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->stream('consent_xray.pdf');
    }
}
