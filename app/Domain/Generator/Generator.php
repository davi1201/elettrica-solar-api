<?php

namespace App\Domain\Generator;

use App\Domain\Solar\Panel;
use App\Entities\MiscellaneousOption;
use App\Entities\Product;
use App\Entities\RoofProduct;
use App\Infrastructure\Services\Aldo\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Generator
{
    protected $id;
    /**
     * @var Product
     */
    protected $product;
    /**
     * @var MiscellaneousOption
     */
    protected $roof;
    /**
     * @var bool
     */
    protected $overcapacity;
    /**
     * @var Panel
     */
    protected $panel;
    /**
     * @var Collection
     */
    protected $transformers;

    /**
     * Generator constructor.
     * @param Product $product
     * @param MiscellaneousOption $roof
     * @param Panel $panel
     * @param bool $overcapacity
     */
    public function __construct(Product $product, MiscellaneousOption $roof, Panel $panel, bool $overcapacity)
    {
        $this->id = Str::uuid()->toString();
        $this->product = $product;
        $this->roof = $roof;
        $this->panel = $panel;
        $this->overcapacity = $overcapacity;
        $this->transformers = collect([]);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return MiscellaneousOption
     */
    public function getRoof(): MiscellaneousOption
    {
        return $this->roof;
    }

    /**
     * @return Panel
     */
    public function getPanel(): Panel
    {
        return $this->panel;
    }

    /**
     * @return bool
     */
    public function isOvercapacity(): bool
    {
        return $this->overcapacity;
    }

    /**
     * @return Collection
     */
    public function getTransformers(): Collection
    {
        return $this->transformers;
    }

    /**
     * @param Collection $transformers
     * @return Generator
     */
    public function setTransformers(Collection $transformers): Generator
    {
        $this->transformers = $transformers;
        return $this;
    }

    public function getPanelCount()
    {
        $components = $this->product->components;

        return $components->filter(function (Component $component) {
            return $component->is('PAINEL SOLAR');
        })->reduce(function ($total, Component $component) {
            return $total + $component->getQuantity();
        }, 0);
    }

    public function getEstimateEnergyGeneration(float $irradiation)
    {
        return $this->panel->getAnnualGeneration($this->getPanelCount(), $irradiation);
    }
}
