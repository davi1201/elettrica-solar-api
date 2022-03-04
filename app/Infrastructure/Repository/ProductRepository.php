<?php

namespace App\Infrastructure\Repository;

use App\Domain\Solar\Panel;
use App\Entities\MiscellaneousOption;
use App\Entities\Product;
use App\Infrastructure\Repository\Filters\RepositoryFilterInterface;
use Illuminate\Support\Str;

class ProductRepository
{
    public function getAll(RepositoryFilterInterface $filter = null)
    {
        $products = Product::select(['codigo', 'descricao','telhado', 'preco', 'potencia', 'active', 'updated_at'])
        ->where('descricao', 'LIKE', '%GERADOR DE ENERGIA SOLAR%');

        if ($filter !== null) {
            $filter->apply($products);
        }

        return $products->paginate();
    }

    public function findGenerator(float $estimatePower, int $voltage, MiscellaneousOption $roofType, Panel $panel, string $inverter = null)
    {
        $roofTypeName = Str::upper($roofType->label);
        $inverterName = $inverter ? Str::upper($inverter) : null;
        $power_panel = $panel->getPower() * 1000;
        $generator = Product::query()
            ->where('active', true)
            ->where('potencia', '>=', $estimatePower)
            ->where('telhado', 'LIKE', "%{$roofTypeName}%")
            ->where('descricao', 'LIKE', "%{$voltage}%")
            ->where('descricao', 'LIKE', "%{$power_panel}W%")
            ->where('descricao', 'LIKE', sprintf('%%%s%%', $panel->getName()))
            ->where('marca', 'LIKE', '%ON GRID%')
            ->orderBy('potencia', 'ASC')
            ->orderBy('preco', 'ASC');

        if ($inverter !== null) {
            $generator->where('categoria', 'LIKE', "%{$inverterName}%");
        }

        return $generator->first();
    }

    public function findTransformerByPower($power)
    {
        return Product::where('categoria', 'like', 'TRANSFORMADOR%')
            ->where('potencia', '>=', $power)
            ->orderBy('potencia')
            ->orderBy('preco')
            ->first();
    }

    public function findMostPowerfulTransformer()
    {
        return Product::where('categoria', 'like', 'TRANSFORMADOR%')
            ->orderBy('potencia', 'desc')
            ->first();
    }
}
