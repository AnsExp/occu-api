<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateKeyRequest;
use App\Http\Services\CertificateKeyService;
use App\Models\CertificateKey;
use App\Policies\CertificateKeyPolicy;
use Illuminate\Http\Request;

class CertificateKeyController extends Controller
{
    public function __construct(
        private CertificateKeyService $certificateKeyService,
        private CertificateKeyPolicy $policy,
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
        $data = CertificateKey::orderBy('created_at', 'desc')->paginate(10);
        return view('certificate_key.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!$this->policy->create(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }
        return view('certificate_key.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CertificateKeyRequest $request)
    {
        if (!$this->policy->create(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }
        $this->certificateKeyService->store($request);
        return redirect()->route('certificate_key.index')->with('success', 'Certificate key created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificateKey $certificateKey)
    {
        if (!$this->policy->view(auth()->user(), $certificateKey)) {
            abort(403, 'Unauthorized action.');
        }
        abort(404, 'Not implemented');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateKey $certificateKey)
    {
        if (!$this->policy->update(auth()->user(), $certificateKey)) {
            abort(403, 'Unauthorized action.');
        }
        abort(404, 'Not implemented');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificateKey $certificateKey)
    {
        if (!$this->policy->update(auth()->user(), $certificateKey)) {
            abort(403, 'Unauthorized action.');
        }
        abort(404, 'Not implemented');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateKey $certificateKey)
    {
        if (!$this->policy->delete(auth()->user(), $certificateKey)) {
            abort(403, 'Unauthorized action.');
        }
        abort(404, 'Not implemented');
    }
}
