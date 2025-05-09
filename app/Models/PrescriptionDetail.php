<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrescriptionDetail extends Model
{
    protected $fillable = [
        'prescription_id',
        'product_service_id',
        'dosis',
        'via',
        'frequency',
        'form',
        'type',
        'duration',
        'instructions',
        'quantity'
    ];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }
}
