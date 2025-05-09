<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPreadmission extends Model
{
    use HasFactory;

    protected $fillable = ['weight', 'size', 'glycemia', 'patient_id', 'is_active', 'appointment_id'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
