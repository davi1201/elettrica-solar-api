<?php

namespace App\Infrastructure\Repository\Filters;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class ProductFilter extends AbstractFilter
{
    /**
     * @return Validator
     */
    function validate(): Validator
    {
        return ValidatorFacade::make($this->values, [
            'codigo' => 'nullable|string|max:500',
            'inverter' => 'nullable|string|max:500',
            'panel' => 'nullable|string',
            'power' => 'nullable|string',
            'structure' => 'nullable|string',
        ]);
    }

    public function applyCodigo(Builder $builder, ?Model $model, $value)
    {
        $builder->where('codigo', 'LIKE', sprintf('%%%s%%', $value));
    }

    public function applyInverter(Builder $builder, ?Model $model, $value)
    {
        $builder->where('descricao', 'LIKE', sprintf('%%%s%%', $value));
    }

    public function applyPanel(Builder $builder, ?Model $model, $value)
    {
        $builder->where('descricao', 'LIKE', sprintf('%%%s%%', $value));
    }

    public function applyPower(Builder $builder, ?Model $model, $value)
    {
        $builder->where('descricao', 'LIKE', sprintf('%%%s%%', $value));
    }

    public function applyStructure(Builder $builder, ?Model $model, $value)
    {
        $builder->where('descricao', 'LIKE', sprintf('%%%s%%', $value));
    }
}
