<?php

namespace App\Http\Controllers;

use App\Models\Companion;
use App\Services\CompanionService;
use App\Http\Requests\Companion\StoreCompanionRequest;
use App\Http\Requests\Companion\UpdateCompanionRequest;

class CompanionController extends Controller
{
    public function __construct(private CompanionService $companionService){}

    public function index()
    {
        $companions = $this->companionService->getCompanions(1);
        return $companions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanionRequest $request)
    {
        $this->companionService->createCompanion($request->validated());

        return redirect()->route('companions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Companion $companion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanionRequest $request, Companion $companion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Companion $companion)
    {
        //
    }
}
