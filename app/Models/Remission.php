<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Remission extends Model
{
    protected $fillable = [
        'receiver_user_id',
        'remitter_user_id',
        'clinical_record_id',
        'receiver_user_specialty_id',
        'note',
        'is_active',
    ];

    public function clinicalRecord() : BelongsTo
    {
        return $this->belongsTo(ClinicalRecord::class);
    }

    public function receiverByUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }

    public function remitterByUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'remitter_user_id');
    }
}
