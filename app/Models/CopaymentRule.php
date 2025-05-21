<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;



class CopaymentRule extends ModelBase
{
    use HasFactory;

    protected $fillable = [
        'attention_type',
        'type_scheme',
        'category',
        'level',
        'type',
        'value',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
        'value' => 'decimal:2',
    ];
}