<?php


namespace App\Infrastructure\Repository\Filters;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class AbstractFilter implements RepositoryFilterInterface
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * AbstractFilter constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    abstract function validate(): Validator;

    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param Builder $query
     * @param Model|null $model
     * @return mixed
     */
    public function apply(Builder $query, ?Model $model = null)
    {
        $validator = $this->validate();
        $values = collect($validator->validate());

        foreach ($values as $name => $value) {
            if ($value === null) {
                continue;
            }

            $methodName = sprintf('apply%s', Str::camel($name));
            $callableFilter = [$this, $methodName];

            if (!is_callable($callableFilter)) {
                continue;
            }

            call_user_func_array($callableFilter, [$query, $model, $value]);
        }
    }
}
