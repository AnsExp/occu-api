<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgreementRequest;
use App\Models\Agreement;
use Illuminate\Http\Request;
use App\Http\Services\AgreementService;

class AgreementController extends Controller
{
    public function __construct(private AgreementService $agreementService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Agreement::paginate(10);
        return view('agreements.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agreements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgreementRequest $request)
    {
        $agreement = $this->agreementService->store($request);
        return redirect()->route('agreements.show', $agreement);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agreement $agreement)
    {
        return view('agreements.show', compact('agreement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agreement $agreement)
    {
        return view('agreements.edit', compact('agreement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agreement $agreement)
    {
        $agreement = $this->agreementService->update($request, $agreement);
        return redirect()->route('agreements.show', $agreement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agreement $agreement)
    {
        //
    }
}
