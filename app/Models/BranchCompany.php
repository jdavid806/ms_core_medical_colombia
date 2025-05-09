<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchCompany extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name', 'email', 'whatsapp', 'address', 'city', 'state', 'country'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function representative()
    {
        return $this->hasOne(BranchRepresentative::class);
    }
}
