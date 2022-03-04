<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Infrastructure\Repository\Filters\ProductFilter;
use App\Infrastructure\Repository\ProductRepository;
use App\Model\ConfigAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $product_repository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->product_repository = $productRepository;
    }

    public function index(Request $request)
    {
        $filter = new ProductFilter($request->query());
        $config_admin = ConfigAdmin::find(1);
        $config_data = [
            'id' => $config_admin->id,
            'percentage_sale' => number_format($config_admin->percentage_sale * 100, 0),
            'percentage_financing' => number_format($config_admin->percentage_financing * 100, 0),
            'percentage_product' => number_format($config_admin->percentage_product * 100, 0)
        ];
        

        $data = [
            'products' => $this->product_repository->getAll($filter),
            'config' => $config_data,
        ];
        
        return new JsonResponse($data, 200);
    }

    public function activeAll()
    {
        Product::query()->update(['active' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
