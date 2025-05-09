<?php

namespace App\Models;

use App\Filters\QueryFilter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function aiResponses(): MorphMany
    {
        return $this->morphMany(AiResponse::class, 'responsable');
    }


    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}