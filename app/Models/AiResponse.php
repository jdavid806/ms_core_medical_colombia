<?php

namespace App\Models;

use App\Filters\QueryFilter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AiResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'responsable_type',
        'responsable_id',
        'agent_id',
        'response',
        'status',
    ];

    protected $casts = [
        'response' => 'array',
    ];

    public function responsable(): MorphTo
    {
        return $this->morphTo();
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }


    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}
