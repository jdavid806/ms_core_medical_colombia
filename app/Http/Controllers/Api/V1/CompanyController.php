<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Company\CompanyResource;
use App\Http\Requests\Api\V1\Company\StoreCompanyRequest;
use App\Http\Requests\Api\V1\Company\UpdateCompanyRequest;

use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $companyService) {}
    public function index()
    {

        $companies = Company::with(['representative', 'billings', 'communication', 'branches.representative'])->get();

        return CompanyResource::collection($companies);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'nullable|string|max:50',
            'document_number' => 'nullable|string|unique:companies,document_number|max:20',
            'logo' => 'nullable|string',
            'watermark' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);

        $company = Company::create($validatedData);

        return response()->json([
            'message' => 'Company created successfully',
            'company' => new CompanyResource($company),
        ], 201);
    }

    public function show($id)
    {

        $company = Company::with(['representative', 'billings', 'communication', 'branches.representative'])->findOrFail($id);


        return new CompanyResource($company);
       
    }

    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'document_type' => ['sometimes', 'required', Rule::in(['DNI', 'RUC', 'PASSPORT'])],
            'document_number' => [
                'sometimes', 'required', 'string', 'max:20',
                Rule::unique('companies', 'document_number')->ignore($company->id),
            ],
            'logo' => 'nullable|string',
            'watermark' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);
    
        // Actualizar los datos de la compañía
        $company->update($validatedData);
    
        return response()->json([
            'message' => 'Company updated successfully',
            'company' => new CompanyResource($company),
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully',
        ], 200);
    }
}
