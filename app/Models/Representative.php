<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Representative extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name', 'phone', 'email', 'document_type', 'document_number'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
