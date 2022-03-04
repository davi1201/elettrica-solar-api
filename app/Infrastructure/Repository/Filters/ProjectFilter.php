<?php

namespace App\Infrastructure\Repository\Filters;

use App\Domain\Client\ClientRelationTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class ProjectFilter extends AbstractFilter
{
    /**
     * @return Validator
     */
    function validate(): Validator
    {
        return ValidatorFacade::make($this->values, [
            'id' => 'nullable|integer',
            'name' => 'nullable|string|max:500',
            'agent' => 'nullable|string',
            'province' => 'nullable|integer',
            'city' => 'nullable',
        ]);
    }

    public function applyName(Builder $builder, ?Model $model, $value)
    {
        $builder->whereHas('client', function (Builder $query) use($value) {
            $query->where('name', 'LIKE', sprintf('%%%s%%', $value));
        });
    }

    public function applyId(Builder $builder, ?Model $model, $value)
    {
        $builder->where('projects.id', $value);
    }

    public function applyAgent(Builder $builder, ?Model $model, $value)
    {
        $builder->whereHas('agent', function (Builder $query) use($value) {
            $query->where('name', 'LIKE', sprintf('%%%s%%', $value));
        });
    }

    public function applyProvince(Builder $builder, ?Model $model, $value)
    {
        $builder->whereHas('client.addresses.city.province', function (Builder $query) use ($value) {
            $query->where('id', $value);
        });
    }

    public function applyCity(Builder $builder, ?Model $model, $value)
    {
        $builder->whereHas('client.addresses.city', function (Builder $query) use ($value) {
            $query->where('id', $value);
        });
    }
}
