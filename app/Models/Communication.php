<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'smtp_server', 'port', 'security', 'email', 'password', 'api_key', 'instance'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

