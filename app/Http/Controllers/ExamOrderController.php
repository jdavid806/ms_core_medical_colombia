<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamOrder\StoreExamOrderRequest;
use App\Http\Requests\ExamOrder\UpdateExamOrderRequest;
use App\Models\AppointmentState;
use App\Models\ExamOrder;
use App\Models\ExamOrderState;
use App\Services\ExamOrderService;

class ExamOrderController extends Controller
{
    protected $service;
    protected $relations = ['patient', 'examType', 'examOrderState', 'examResult', 'doctor', 'items.exam'];

    public function __construct(ExamOrderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAll()->load($this->relations);
    }

    public function show($id)
    {
        return $this->service->getById($id)->load($this->relations);
    }

    public function store(StoreExamOrderRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateExamOrderRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function finishAppointment($examOrderId)
    {
        $examOrder = ExamOrder::find($examOrderId);
        $examOrder->exam_order_state_id = ExamOrderState::where('name', 'uploaded')->first()->id;
        $examOrder->save();

        $appointment = $examOrder->appointment;
        $appointment->appointment_state_id = AppointmentState::where('name', 'consultation_completed')->first()->id;
        $appointment->save();

        return $examOrder;
    }

    public function updateMinioFile($examOrderId, $minioId)
    {
        $examOrder = ExamOrder::find($examOrderId);
        $examOrder->minio_id = $minioId;
        $examOrder->exam_order_state_id = ExamOrderState::where('name', 'uploaded')->first()->id;
        $examOrder->save();

        $appointment = $examOrder->appointment;
        $appointment->appointment_state_id = AppointmentState::where('name', 'consultation_completed')->first()->id;
        $appointment->save();

        return $$examOrder;
    }

    public function getLastbyPatient($patientId)
    {
        return $this->service->getLastbyPatient($patientId)->load($this->relations);
    }
}
