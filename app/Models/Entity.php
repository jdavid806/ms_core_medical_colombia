<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'document_type',
        'document_number',
        'email',
        'address',
        'phone',
        'city_id',
        'tax_charge_id',
        'withholding_tax_id',
        'koneksi_sponsor_slug',
    ];

    //construye un json con los fillable
    
    public function socialSecurities(): HasMany
    {
        return $this->hasMany(SocialSecurity::class);
    }

    
}
