<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function __construct(private OfficeService $officeService) {}

    public function index()
    {
        $offices = $this->officeService->getAllOffices();
        return OfficeResource::collection($offices);
    }

    public function store(StoreOfficeRequest $request)
    {
        $office = $this->officeService->createOffice($request->validated());
        return response()->json([
            'message' => 'Office created successfully',
            'Office' => $office,
        ]);
    }

    public function show(Office $office)
    {
        return new OfficeResource($office);
    }

    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $this->officeService->updateOffice($office, $request->validated());
        return response()->json([
            'message' => 'Office updated successfully',
        ]);
    }

    public function destroy(Office $office)
    {
        $this->officeService->deleteOffice($office);
        return response()->json([
            'message' => 'Office deleted successfully',
        ]);
    }

    //
}
