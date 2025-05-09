<?php

namespace App\Filters;

class PatientFilter extends QueryFilter
{
    protected array $sortable = [
        'documentNumber' => 'document_number',
        'whatsapp',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function documentNumber(string $value): void
    {
        $this->builder->where('document_number', 'LIKE', "%$value%");
    }

    public function whatsapp(string $value): void
    {
        $this->builder->where('whatsapp', 'LIKE', "%$value%");
    }

    public function createdAt(string $value): void
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            $this->builder->whereBetween('created_at', $dates);
        } else {
            $this->builder->whereDate('created_at', $value);
        }
    }

    public function updatedAt(string $value): void
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            $this->builder->whereBetween('updated_at', $dates);
        } else {
            $this->builder->whereDate('updated_at', $value);
        }
    }

    public function include(string $value): void
    {
        $this->builder->with(explode(',', $value));
    }
}