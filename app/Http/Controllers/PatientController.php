<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PatientService;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;

class PatientController extends Controller
{
    protected $service;
    protected $relations = [
        'socialSecurity.entity',
        'companions',
        'appointments',
        'appointments.userAvailability',
        'appointments.appointmentState',
        'vaccineApplications',
        'disabilities',
        'nursingNotes',
        'clinicalRecords'
    ];

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service
            ->getAll()
            ->load($this->relations);
    }

    public function show($id)
    {
        return $this->service
            ->getById($id)
            ->load($this->relations);
    }

    public function store(StorePatientRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function evolution($id)
    {
        return $this->service->evolution($id);
    }

    public function getByPhone($phone)
    {
        return $this->service->getByPhone($phone)->load($this->relations);
    }

    public function getByDocument($document)
    {
        return $this->service->getByDocument($document)->load($this->relations);
    }
}
