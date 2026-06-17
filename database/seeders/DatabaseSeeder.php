<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        $electronics = Category::query()->updateOrCreate([
            'slug' => 'electronics',
        ], [
            'name' => 'Электроника',
            'description' => 'Гаджеты, техника и умные устройства для дома и работы.',
        ]);

        $fashion = Category::query()->updateOrCreate([
            'slug' => 'fashion',
        ], [
            'name' => 'Одежда',
            'description' => 'Повседневная одежда и аксессуары для разных сезонов.',
        ]);

        $home = Category::query()->updateOrCreate([
            'slug' => 'home',
        ], [
            'name' => 'Дом',
            'description' => 'Товары для кухни, быта и уютного интерьера.',
        ]);

        $smartphone = Product::query()->updateOrCreate([
            'slug' => 'smart-phone',
        ], [
            'name' => 'Смартфон',
            'description' => 'Современный смартфон с ярким экраном, быстрой зарядкой и удобной камерой.',
            'price' => 499.99,
            'image' => 'images/products/smart-phone.svg',
            'stock_quantity' => 15,
            'is_available' => true,
        ]);
        $smartphone->categories()->syncWithoutDetaching([$electronics->id]);

        $laptop = Product::query()->updateOrCreate([
            'slug' => 'laptop',
        ], [
            'name' => 'Ноутбук',
            'description' => 'Лёгкий ноутбук для работы, учёбы и повседневных задач.',
            'price' => 1299.00,
            'image' => 'images/products/laptop.svg',
            'stock_quantity' => 7,
            'is_available' => true,
        ]);
        $laptop->categories()->syncWithoutDetaching([$electronics->id]);

        $shirt = Product::query()->updateOrCreate([
            'slug' => 'shirt',
        ], [
            'name' => 'Рубашка',
            'description' => 'Хлопковая рубашка для повседневной носки и аккуратного образа.',
            'price' => 49.90,
            'image' => 'images/products/shirt.svg',
            'stock_quantity' => 30,
            'is_available' => true,
        ]);
        $shirt->categories()->syncWithoutDetaching([$fashion->id]);

        $mug = Product::query()->updateOrCreate([
            'slug' => 'ceramic-mug',
        ], [
            'name' => 'Керамическая кружка',
            'description' => 'Прочная кружка для кофе, чая и ежедневного использования.',
            'price' => 14.50,
            'image' => 'images/products/ceramic-mug.svg',
            'stock_quantity' => 40,
            'is_available' => true,
        ]);
        $mug->categories()->syncWithoutDetaching([$home->id, $electronics->id]);

        $headphones = Product::query()->updateOrCreate([
            'slug' => 'wireless-headphones',
        ], [
            'name' => 'Беспроводные наушники',
            'description' => 'Компактные наушники с чистым звуком и долгой автономной работой.',
            'price' => 199.00,
            'image' => 'images/products/wireless-headphones.svg',
            'stock_quantity' => 22,
            'is_available' => true,
        ]);
        $headphones->categories()->syncWithoutDetaching([$electronics->id]);

        $tablet = Product::query()->updateOrCreate([
            'slug' => 'tablet',
        ], [
            'name' => 'Планшет',
            'description' => 'Удобный планшет для чтения, фильмов и работы в дороге.',
            'price' => 799.00,
            'image' => 'images/products/tablet.svg',
            'stock_quantity' => 11,
            'is_available' => true,
        ]);
        $tablet->categories()->syncWithoutDetaching([$electronics->id]);

        $sneakers = Product::query()->updateOrCreate([
            'slug' => 'sneakers',
        ], [
            'name' => 'Кроссовки',
            'description' => 'Лёгкие кроссовки для прогулок, спорта и повседневной носки.',
            'price' => 89.90,
            'image' => 'images/products/sneakers.svg',
            'stock_quantity' => 18,
            'is_available' => true,
        ]);
        $sneakers->categories()->syncWithoutDetaching([$fashion->id]);

        $blender = Product::query()->updateOrCreate([
            'slug' => 'blender',
        ], [
            'name' => 'Блендер',
            'description' => 'Практичный блендер для смузи, соусов и домашних заготовок.',
            'price' => 129.50,
            'image' => 'images/products/blender.svg',
            'stock_quantity' => 9,
            'is_available' => true,
        ]);
        $blender->categories()->syncWithoutDetaching([$home->id]);
    }
}
