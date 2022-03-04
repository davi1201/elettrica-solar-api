<?php


namespace App\Infrastructure\Services\Project;

use App\Domain\Generator\Generator;
use App\Entities\Product;
use App\Exceptions\UndefinedTransformerException;
use App\Infrastructure\Repository\ProductRepository;
use App\Infrastructure\Services\Aldo\Component;
use Illuminate\Support\Collection;
use function GuzzleHttp\Promise\all;

class GeneratorTransformer
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProjectTransformer constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getTransformers(Generator $generator): array {
        if (false === $generator->isOvercapacity()) {
            return [];
        }

        $totalInvertersKva = $this->calculatePowerInverterKva($generator);
        if ($totalInvertersKva <= 0) {
            //throw new UndefinedTransformerException('Ocorreu um erro ao tentar calcular o transformador');
            return ['Error'];
        }

        $transformers = [];

        while ($totalInvertersKva > 0) {
            $transformer = $this->productRepository->findTransformerByPower($totalInvertersKva);

            if ($transformer !== null) {
                $totalInvertersKva -= $transformer->potencia;
                $transformers[] = $transformer;
                continue;
            }

            $transformer = $this->productRepository->findMostPowerfulTransformer();
            $totalInvertersKva -= $transformer->potencia;

            $transformers[] = $transformer;
        }

        return $transformers;
    }

    public function getInverters(Product $product): Collection
    {
        $components = $product->components;

        return $components->filter(function (Component $component) {
            return $component->is('inversor');
        });
    }

    private function calculatePowerInverterKva(Generator $generator): float
    {
        $product = $generator->getProduct();
        $inverters = $this->getInverters($product);

        $totalInvertersKva = $inverters->reduce(function ($total, Component $item) {
            $total += ($item->getKva() * $item->getQuantity());
            return $total;
        }, 0);

        return $totalInvertersKva;
    }
}
