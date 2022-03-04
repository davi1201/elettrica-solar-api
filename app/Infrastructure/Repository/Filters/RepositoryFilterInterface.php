<?php

namespace App\Infrastructure\Repository\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface RepositoryFilterInterface
{
    public function apply(Builder $query, ?Model $model = null);

    public function getValues(): array;
}
