<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationCredential extends ModelBase
{

    protected $table = 'integration_credentials';

    protected $fillable = [
        'integration_id',
        'key',
        'value',
        'is_sensitive',
    ];


    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }

}