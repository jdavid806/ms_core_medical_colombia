<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComissionConfigService extends Model
{
    protected $table = 'comission_config_service';

    protected $fillable = [
        'commission_config_id',
        'service_id',
    ];

    public $timestamps = true;

    public function comissionConfig()
    {
        return $this->belongsTo(ComissionConfig::class, 'commission_config_id');
    }
}
