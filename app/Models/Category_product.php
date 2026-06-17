<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryProductFactory> */
    use HasFactory;

    protected $table = 'category_products';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'product_id',
    ];
}
