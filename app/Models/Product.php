<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'prise',
        'image',
        'stock_quantity',
        'is_available',
        'created_at',
        'updated_at',
    ];
    public function category_products(): HasMany
    {
        return $this->hasMany(Category_product::class);
    }
    public function cart_items(): HasMany
    {
        return $this->hasMany(Cart_item::class);
    }
    public function order_items(): HasMany
    {
        return $this->hasMany(Order_item::class);
    }
}
