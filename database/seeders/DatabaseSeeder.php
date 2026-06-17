<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $electronics = Category::query()->updateOrCreate([
            'slug' => 'electronics',
        ], [
            'name' => 'Electronics',
            'description' => 'Gadgets, devices and smart home items.',
        ]);

        $fashion = Category::query()->updateOrCreate([
            'slug' => 'fashion',
        ], [
            'name' => 'Fashion',
            'description' => 'Clothing and everyday accessories.',
        ]);

        $home = Category::query()->updateOrCreate([
            'slug' => 'home',
        ], [
            'name' => 'Home',
            'description' => 'Kitchen, home and lifestyle items.',
        ]);

        $smartphone = Product::query()->updateOrCreate([
            'slug' => 'smart-phone',
        ], [
            'name' => 'Smartphone',
            'description' => 'A modern smartphone with a bright screen and fast charging.',
            'price' => 499.99,
            'image' => 'images/products/smart-phone.svg',
            'stock_quantity' => 15,
            'is_available' => true,
        ]);
        $smartphone->categories()->syncWithoutDetaching([$electronics->id]);

        $laptop = Product::query()->updateOrCreate([
            'slug' => 'laptop',
        ], [
            'name' => 'Laptop',
            'description' => 'Lightweight laptop for work, study and everyday tasks.',
            'price' => 1299.00,
            'image' => 'images/products/laptop.svg',
            'stock_quantity' => 7,
            'is_available' => true,
        ]);
        $laptop->categories()->syncWithoutDetaching([$electronics->id]);

        $shirt = Product::query()->updateOrCreate([
            'slug' => 'shirt',
        ], [
            'name' => 'Shirt',
            'description' => 'Cotton shirt for daily wear and a neat look.',
            'price' => 49.90,
            'image' => 'images/products/shirt.svg',
            'stock_quantity' => 30,
            'is_available' => true,
        ]);
        $shirt->categories()->syncWithoutDetaching([$fashion->id]);

        $mug = Product::query()->updateOrCreate([
            'slug' => 'ceramic-mug',
        ], [
            'name' => 'Ceramic Mug',
            'description' => 'A durable mug for coffee, tea and everyday use.',
            'price' => 14.50,
            'image' => 'images/products/ceramic-mug.svg',
            'stock_quantity' => 40,
            'is_available' => true,
        ]);
        $mug->categories()->syncWithoutDetaching([$home->id, $electronics->id]);

        $headphones = Product::query()->updateOrCreate([
            'slug' => 'wireless-headphones',
        ], [
            'name' => 'Wireless Headphones',
            'description' => 'Compact headphones with clear sound and long battery life.',
            'price' => 199.00,
            'image' => 'images/products/wireless-headphones.svg',
            'stock_quantity' => 22,
            'is_available' => true,
        ]);
        $headphones->categories()->syncWithoutDetaching([$electronics->id]);

        $tablet = Product::query()->updateOrCreate([
            'slug' => 'tablet',
        ], [
            'name' => 'Tablet',
            'description' => 'A convenient tablet for reading, movies and work on the go.',
            'price' => 799.00,
            'image' => 'images/products/tablet.svg',
            'stock_quantity' => 11,
            'is_available' => true,
        ]);
        $tablet->categories()->syncWithoutDetaching([$electronics->id]);

        $sneakers = Product::query()->updateOrCreate([
            'slug' => 'sneakers',
        ], [
            'name' => 'Sneakers',
            'description' => 'Lightweight sneakers for walks, sports and everyday wear.',
            'price' => 89.90,
            'image' => 'images/products/sneakers.svg',
            'stock_quantity' => 18,
            'is_available' => true,
        ]);
        $sneakers->categories()->syncWithoutDetaching([$fashion->id]);

        $blender = Product::query()->updateOrCreate([
            'slug' => 'blender',
        ], [
            'name' => 'Blender',
            'description' => 'A practical blender for smoothies, sauces and home cooking.',
            'price' => 129.50,
            'image' => 'images/products/blender.svg',
            'stock_quantity' => 9,
            'is_available' => true,
        ]);
        $blender->categories()->syncWithoutDetaching([$home->id]);

        User::query()->updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::query()->updateOrCreate([
            'email' => 'customer@admin.com',
        ], [
            'name' => 'customer',
            'password' => Hash::make('customer'),
            'role' => 'customer',
        ]);
    }
}
