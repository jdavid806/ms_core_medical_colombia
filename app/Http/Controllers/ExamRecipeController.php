<?php

namespace App\Http\Controllers;

use App\Models\ExamRecipe;
use App\Models\Patient;

class ExamRecipeController extends BasicController
{
    protected $service;
    protected $relations = ['details.examType', 'user'];

    public function index()
    {
        return ExamRecipe::all()->load($this->relations);
    }

    public function show(ExamRecipe $examRecipe)
    {
        return $examRecipe->load($this->relations);
    }

    public function ofPatient(Patient $patient)
    {
        return $patient->examRecipes()->with($this->relations)->get();
    }

    public function changeStatus(ExamRecipe $examRecipe, string $status)
    {
        $examRecipe->update(['status' => $status]);
        return $examRecipe->load($this->relations);
    }

    public function lastByPatient($patientId)
    {
        return ExamRecipe::where('patient_id', $patientId)
            ->orderBy('id', 'desc')
            ->first()
            ->load($this->relations);
    }

    public function getPending()
    {
        return ExamRecipe::where('status', 'pending')->with($this->relations)->get();
    }

    public function getPendingOfPatient(Patient $patient)
    {
        return $patient->examRecipes()->where('status', 'pending')->with($this->relations)->get();
    }
}
