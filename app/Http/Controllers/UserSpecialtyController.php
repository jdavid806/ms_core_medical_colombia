<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserSpecialtyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserSpecialtyController extends Controller
{


    public function __construct(private UserSpecialtyService $userSpecialtyService){}


    public function index()
    {
        return $this->userSpecialtyService->getAll()->load(['users', 'menus', 'specializables']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'specialty_id' => 'required|integer',
        ]);

        try {
            $userSpecialty = $this->userSpecialtyService->createUserSpecialty($request->specialty_id);
            return response()->json($userSpecialty, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
