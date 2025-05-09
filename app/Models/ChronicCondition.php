<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChronicCondition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'chronic_conditions';

    protected $fillable = [
        'cie11_code',
        'name',
    ];

}
