<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Http;

class ComissionConfig extends Model
{
    protected $table = 'comission_config';

    protected $fillable = [
        'attention_type',
        'application_type',
        'commission_type',
        'percentage_base',
        'percentage_value',
        'commission_value',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(ComissionConfigService::class, 'commission_config_id');
    }
}
