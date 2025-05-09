<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialSecurity extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'type_scheme',
        'affiliate_type',
        'category',
        'entity_id',
        'arl',
        'afp',
        'insurer',
    ];

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}