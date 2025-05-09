<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository extends BaseRepository
{
    protected $model;

    public function __construct(Patient $model)
    {
        $this->model = $model;
    }

    public function evolution($id)
    {
        $patient = $this->model->find($id);

        $events = collect(); // Creamos una colección base vacía

        // Concatenamos cada colección mapeada
        $events = $events->concat($patient->clinicalRecords->map(function ($clinicalRecord) {
            return [
                'created_at' => $clinicalRecord->created_at,
                'title' => 'Se creó una historia clínica de tipo: ' . $clinicalRecord->clinicalRecordType->name,
                'content' => 'Aquí irían las observaciones',
                'type' => 'clinical_record'
            ];
        }))->concat($patient->exams->map(function ($exam) {
            return [
                'created_at' => $exam->created_at,
                'title' => 'Se realizó un examen',
                'content' => 'Aquí irían las observaciones',
                'type' => 'exam'
            ];
        }))->concat($patient->disabilities->map(function ($disability) {
            return [
                'created_at' => $disability->created_at,
                'title' => 'Se creó una incapacidad',
                'content' => $disability->reason,
                'type' => 'disability'
            ];
        }))->concat($patient->evolutionNotes->map(function ($evolutionNote) {
            return [
                'created_at' => $evolutionNote->created_at,
                'title' => 'Se creó una nota de evolución',
                'content' => $evolutionNote->note,
                'type' => 'evolution_note'
            ];
        }))->concat($patient->nursingNotes->map(function ($nursingNote) {
            return [
                'created_at' => $nursingNote->created_at,
                'title' => 'Se creó una nota de enfermería',
                'content' => $nursingNote->note,
                'type' => 'nursing_note'
            ];
        }))->sortBy('created_at')->values();

        return $events;
    }

    public function getByPhone($phone)
    {
        return $this->model->where('whatsapp', 'like', '%' . $phone . '%')->get();
    }

    public function getByDocument($document)
    {
        return $this->model->where('document_number', 'like', '%' . $document . '%')->get();
    }

    public function getPatientsForDoctor($doctorId, $day, array $filters, $perPage = 10)
    {
        $query = $this->model->whereHas('appointments', function ($query) use ($doctorId, $day) {
            $query->whereHas('assignedUserAvailability', function ($subQuery) use ($doctorId) {
                $subQuery->where('user_id', $doctorId);
            })->whereDate('appointment_date', $day);
        });

        $query = $this->applyFilters($query, $filters);

        return $query->with(['appointments' => function ($query) use ($day) {
            $query->whereDate('appointment_date', $day);
        }])->paginate($perPage);
    }

    public function getPatientsForAdmin(array $filters, $perPage = 10)
    {
        $query = $this->model->whereHas('appointments')->with(['appointments.appointmentState']);

        $query = $this->applyFilters($query, $filters);

        return $query->paginate($perPage);
    }

    public function getPatientsWithAppointmentsForDoctor($doctorId, $day, array $filters, $perPage = 10)
    {
        $query = $this->model->whereHas('appointments', function ($query) use ($doctorId, $day) {
            $query->whereHas('assignedUserAvailability', function ($subQuery) use ($doctorId) {
                $subQuery->where('user_id', $doctorId);
            })->whereDate('appointment_date', $day);
        });

        $query = $this->applyFilters($query, $filters);

        return $query->with(['appointments' => function ($query) use ($doctorId, $day) {
            $query->whereDate('appointment_date', $day)
                ->whereHas('assignedUserAvailability', function ($subQuery) use ($doctorId) {
                    $subQuery->where('user_id', $doctorId);
                })
                ->with('appointmentState'); // Carga el estado si es necesario
        }])->paginate($perPage);
    }

    public function getPatientsWithAppointmentsForAdmin($day, array $filters, $perPage = 10)
    {
        $query = $this->model->whereHas('appointments', function ($query) use ($day) {
            $query->whereDate('appointment_date', $day);
        });

        $query = $this->applyFilters($query, $filters);

        return $query->with(['appointments' => function ($query) use ($day) {
            $query->whereDate('appointment_date', $day)
                ->with('appointmentState'); // Carga el estado
        }])->paginate($perPage);
    }

    private function applyFilters($query, array $filters)
    {
        if (!empty($filters['name'])) {

            $query->where('first_name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['identification'])) {
            $query->where('document_number', 'like', '%' . $filters['identification'] . '%');
        }

        if (!empty($filters['phone'])) {
            $query->where('whatsapp', 'like', '%' . $filters['phone'] . '%');
        }

        if (!empty($filters['appointment_status'])) {
            $query->whereHas('appointments', function ($subQuery) use ($filters) {
                $subQuery->whereHas('appointmentState', function ($stateQuery) use ($filters) {
                    $stateQuery->where('id', $filters['appointment_status']);
                });
            });
        }

        return $query;
    }
}
