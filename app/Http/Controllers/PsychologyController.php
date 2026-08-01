<?php

namespace App\Http\Controllers;

use App\Http\Requests\PsychologyRequest;
use App\Http\Services\CertificateSearchService;
use App\Http\Services\PsychologyService;
use App\Models\Certificate;
use App\Policies\CertificatePolicy;
use Illuminate\Http\Request;
use Storage;

class PsychologyController extends CertificateController
{
    protected $type = 'psychology';

    public function __construct(
        private CertificateSearchService $certificateSearchService,
        private PsychologyService $psychologyService,
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
        return view('psychology.index', compact('certificates'));
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
        return view('psychology.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PsychologyRequest $request)
    {
        if (!$this->policy->create(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }
        $psychology = $this->psychologyService->store($request);
        return redirect()->route('psychology.show', $psychology);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $psychology)
    {
        if (!$this->policy->view(auth()->user(), $psychology)) {
            abort(403, 'Unauthorized action.');
        }
        $filePath = $psychology->file_path;
        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'PDF file not found.');
        }
        return response()->file(storage_path('app/private/' . $filePath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $psychology->order->order_number . '.pdf"',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        if (!$this->policy->update(auth()->user(), $certificate)) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        if (!$this->policy->update(auth()->user(), $certificate)) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        if (!$this->policy->delete(auth()->user(), $certificate)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
