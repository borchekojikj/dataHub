<?php

// app/Models/Product.php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'store_id',
        'regular_price',
        'discounted_price',
        'manufacturer_id',
        'product_url',
        'discount_percentage',
        'image_url',
        'in_stock',
        'product_code',
        'category_id',
        'category_link',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
