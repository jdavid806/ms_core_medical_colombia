<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamOrder extends Model
{
    use HasFactory;

    protected $table = 'exam_orders';

    protected $fillable = [
        'exam_type_id',
        'patient_id',
        'exam_order_state_id',
        'doctor_id',
        'appointment_id',
        'is_active'
    ];

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function examOrderState()
    {
        return $this->belongsTo(ExamOrderState::class);
    }

    public function examResult():HasMany
    {
        return $this->hasMany(ExamResult::class, 'exam_order_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function items()
    {
        return $this->hasMany(ExamOrderItem::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function clinicalRecord()
    {
        return $this->belongsTo(ClinicalRecord::class);
    }
}
