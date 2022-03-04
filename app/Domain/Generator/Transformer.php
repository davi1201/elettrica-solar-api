<?php

namespace App\Domain\Generator;

use App\Entities\Product;

class Transformer
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * Transformer constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getPower()
    {
        return $this->product->potencia;
    }
}
