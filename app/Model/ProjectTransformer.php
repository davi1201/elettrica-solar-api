<?php

namespace App\Model;

use App\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class ProjectTransformer extends Model
{
  protected $fillable = [
      'project_id',
      'product_code',
      'quantity'
  ];

  public function product()
  {
      return $this->hasOne(Product::class, 'codigo', 'product_code');
  }
}
