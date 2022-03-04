<?php
namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProjectDiscount extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'price',
        'price_with_discount',
        'discount_value',
        'percentage_discount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
