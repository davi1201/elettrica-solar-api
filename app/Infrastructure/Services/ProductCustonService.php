<?php 

namespace App\Infrastructure\Services;

use App\ProductCuston;

class ProductCustonService {

    public function create(Array $data)
    {
        $productCuston = new ProductCuston($data);

        $productCuston->save();

        return $productCuston;
    }

    public function update(Array $data, ProductCuston $productCuston)
    {
        $productCuston->update($data);

        return $productCuston;
    }
}