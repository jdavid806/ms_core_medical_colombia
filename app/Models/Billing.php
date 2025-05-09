<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'dian_prefix', 'resolution_number', 'invoice_from', 'invoice_to', 'resolution_date', 'expiration_date', 'type', 'accounting_account'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // En tu modelo Billing (App\Models\Billing.php)
    public function setTypeAttribute($value)
    {
        $allowedValues = [
            'consumer' => 'Consumidor',
            'government_invoice' => 'Factura gubernamental',
            'tax_invoice' => 'Factura fiscal',
            'credit_note' => 'Nota crédito',
        ];

        if (!in_array($value, array_keys($allowedValues))) {
            throw new \InvalidArgumentException("Invalid type value");
        }

        $this->attributes['type'] = $value;
    }
}
