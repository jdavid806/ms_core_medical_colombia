<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComissionConfigUser extends Model
{
    protected $table = 'comission_config_user';

    protected $fillable = [
        'comission_config_id',
        'user_id',
    ];

    public $timestamps = true;

    public function commissionConfig()
    {
        return $this->belongsTo(ComissionConfig::class, 'comission_config_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
