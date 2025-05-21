<?php

namespace App\Models;


class ExternalProductCache extends ModelBase
{
    protected $table = 'external_products_cache';
    protected $connection = 'tenant';

    protected $fillable = [
        'external_id',
        'name',
        'purchase_price',
        'sale_price',
        'synced_at',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'synced_at' => 'datetime',
    ];
}
