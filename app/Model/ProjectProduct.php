<?php

namespace App\Model;

use App\Entities\Product;
use App\ProductCuston;
use Illuminate\Database\Eloquent\Model;

class ProjectProduct extends Model
{
    protected $fillable = [
        'project_id',
        'product_id',
        'product_code',
        'price',
        'power',
        'panel_count',
        'estimate_power',
        'quantity'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'codigo', 'product_code');
    }

    public function productCuston()
    {
        return $this->belongsTo(ProductCuston::class);
    }
}
