<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationUser extends ModelBase
{

    protected $table = 'integration_users';

    protected $fillable = [
        'integration_id',
        'user_id',
        'status',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}