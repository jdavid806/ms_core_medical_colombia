<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonaNatural extends Model
{
    protected $fillable = [
        'office_id', 'document_type', 'document_number', 'first_name', 'last_name'
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
