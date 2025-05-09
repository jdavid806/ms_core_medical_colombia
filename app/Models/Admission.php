<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'patient_id',
        'user_id',
        'admission_type_id',
        'authorization_number',
        'authorization_date',
        'appointment_id',
        'invoice_id',
        'is_active',
        'entity_id',
        'entity_authorized_amount',
        'document_minio_id',
        'koneksi_claim_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function admissionType()
    {
        return $this->belongsTo(AdmissionType::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}
