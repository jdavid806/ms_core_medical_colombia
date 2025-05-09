<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'legal_name', 'document_type', 'document_number', 'logo', 'watermark',
        'phone', 'email', 'address', 'country', 'province', 'city', 'trade_name', 'economic_activity'
    ];

    public function representative()
    {
        return $this->hasOne(Representative::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function communication()
    {
        return $this->hasOne(Communication::class);
    }


    public function branches()
    {
        return $this->hasMany(BranchCompany::class);
    }
}