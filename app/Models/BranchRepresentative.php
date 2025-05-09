<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchRepresentative extends Model
{
    use HasFactory;

    protected $fillable = ['branch_company_id', 'name', 'phone'];

    public function branch()
    {
        return $this->belongsTo(BranchCompany::class);
    }
}
