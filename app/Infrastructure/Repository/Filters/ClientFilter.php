<?php

namespace App\Infrastructure\Repository\Filters;

use App\Domain\Client\ClientRelationTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class ClientFilter extends AbstractFilter
{
    /**
     * @return Validator
     */
    function validate(): Validator
    {
        return ValidatorFacade::make($this->values, [            
            'name' => 'nullable|string|max:500',
            'province' => 'nullable|integer',
            'city' => 'nullable',
        ]);
    }

    public function applyName(Builder $builder, ?Model $model, $value)
    {        
        $builder->where('name', 'LIKE', sprintf('%%%s%%', $value));
    }

    public function applyProvince(Builder $builder, ?Model $model, $value)
    {
        $builder->whereHas('addresses.city.province', function (Builder $query) use ($value) {
            $query->where('id', $value);
        });
    }

    public function applyCity(Builder $builder, ?Model $model, $value)
    {
        $builder->whereHas('addresses.city', function (Builder $query) use ($value) {
            $query->where('id', $value);
        });
    }
}
