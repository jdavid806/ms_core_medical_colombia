<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\BranchCompany;
use App\Http\Controllers\Controller;
use App\Models\BranchRepresentative;
use App\Services\BranchCompanyService;
use App\Http\Resources\Api\V1\BranchCompany\BranchCompanyResource;
use App\Http\Requests\Api\V1\BranchCompany\StoreBranchCompanyRequest;
use App\Http\Requests\Api\V1\BranchCompany\UpdateBranchCompanyRequest;

class BranchCompanyController extends Controller
{
    public function __construct(private BranchCompanyService $branchCompanyService) {}

    public function index()
    {
        $branchCompanys = $this->branchCompanyService->getAllBranchCompanys();
        return BranchCompanyResource::collection($branchCompanys);
    }

    public function store(Request $request, Company $company)
    {
        // Validar los datos tanto de la sucursal como del representante
        $validatedData = $request->validate([
            // Datos de la sucursal
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
    
            // Datos del representante
            'representative.name' => 'required|string|max:255',
            'representative.phone' => 'required|string|max:20',
        ]);
    
        // Crear la sucursal y asociarla con la compañía
        $branchData = $validatedData;
        unset($branchData['representative']); // Eliminar los datos del representante para la sucursal
        $branchData['company_id'] = $company->id;
    
        $branch = BranchCompany::create($branchData);
    
        // Crear y asociar al representante con la sucursal
        $representativeData = $validatedData['representative'];
        $representativeData['branch_company_id'] = $branch->id;
    
        $representative = BranchRepresentative::create($representativeData);
    
        return response()->json([
            'message' => 'Branch and representative created successfully',
            'branch' => $branch,
            'representative' => $representative,
        ], 201);
    }
    

    public function show(Company $company, BranchCompany $branch)
    {
        if ($branch->company_id !== $company->id) {
            return response()->json([
                'message' => 'This branch does not belong to the specified company',
            ], 404);
        }
    
        $representative = $branch->representative;
    
        return response()->json([
            'branch' => $branch,
            'representative' => $representative,
        ]);
    }
    

    public function update(Request $request, Company $company, BranchCompany $branch)
    {
        if ($branch->company_id !== $company->id) {
            return response()->json([
                'message' => 'This branch does not belong to the specified company',
            ], 404);
        }
    
        $validatedData = $request->validate([
            // Validación para la sucursal
            'name' => 'string|max:255',
            'email' => 'email',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
    
            // Validación para el representante
            'representative.name' => 'string|max:255',
            'representative.phone' => 'string|max:20',
        ]);
    
        // Actualizar los datos de la sucursal
        $branchData = $validatedData;
        unset($branchData['representative']); // Eliminar los datos del representante para actualizarlos por separado
        $branch->update($branchData);
    
        // Actualizar los datos del representante (si existe)
        if ($branch->representative) {
            $branch->representative->update($validatedData['representative']);
        } else {
            // Si no existe un representante, crear uno nuevo
            $representativeData = $validatedData['representative'];
            $representativeData['branch_company_id'] = $branch->id;
            BranchRepresentative::create($representativeData);
        }
    
        return response()->json([
            'message' => 'Branch and representative updated successfully',
            'branch' => $branch,
            'representative' => $branch->representative,
        ]);
    }
    


    public function destroy(Company $company, BranchCompany $branch)
    {
        if ($branch->company_id !== $company->id) {
            return response()->json([
                'message' => 'This branch does not belong to the specified company',
            ], 404);
        }
    
        // Eliminar el representante si existe
        if ($branch->representative) {
            $branch->representative->delete();
        }
    
        // Eliminar la sucursal
        $branch->delete();
    
        return response()->json([
            'message' => 'Branch and its representative deleted successfully',
        ]);
    }
    
}
