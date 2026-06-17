<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
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
        $categories = [
            ['slug' => 'electronics', 'name' => 'Электроника', 'description' => 'Гаджеты, устройства и техника для повседневной жизни.'],
            ['slug' => 'fashion', 'name' => 'Одежда', 'description' => 'Одежда, обувь и аксессуары.'],
            ['slug' => 'home', 'name' => 'Дом и кухня', 'description' => 'Товары для дома, кухни и уюта.'],
            ['slug' => 'sports', 'name' => 'Спорт', 'description' => 'Инвентарь и товары для активного отдыха.'],
            ['slug' => 'office', 'name' => 'Офис', 'description' => 'Всё для работы, учёбы и организации пространства.'],
            ['slug' => 'beauty', 'name' => 'Красота', 'description' => 'Уход, косметика и аксессуары для ежедневного использования.'],
            ['slug' => 'kids', 'name' => 'Детям', 'description' => 'Полезные и практичные товары для детей.'],
            ['slug' => 'books', 'name' => 'Книги', 'description' => 'Книги, блокноты и товары для чтения.'],
        ];

        $categoryModels = [];

        foreach ($categories as $categoryData) {
            $categoryModels[$categoryData['slug']] = Category::query()->updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                ]
            );
        }

        $products = [
            ['slug' => 'smart-phone', 'name' => 'Смартфон', 'description' => 'Современный смартфон с ярким экраном и быстрой зарядкой.', 'price' => 499.99, 'image' => 'images/products/smart-phone.svg', 'stock_quantity' => 15, 'is_available' => true, 'categories' => ['electronics']],
            ['slug' => 'laptop', 'name' => 'Ноутбук', 'description' => 'Лёгкий ноутбук для работы, учёбы и ежедневных задач.', 'price' => 1299.00, 'image' => 'images/products/laptop.svg', 'stock_quantity' => 7, 'is_available' => true, 'categories' => ['electronics', 'office']],
            ['slug' => 'wireless-headphones', 'name' => 'Беспроводные наушники', 'description' => 'Компактные наушники с чистым звуком и долгой работой от батареи.', 'price' => 199.00, 'image' => 'images/products/wireless-headphones.svg', 'stock_quantity' => 22, 'is_available' => true, 'categories' => ['electronics', 'sports']],
            ['slug' => 'tablet', 'name' => 'Планшет', 'description' => 'Удобный планшет для чтения, фильмов и работы в дороге.', 'price' => 799.00, 'image' => 'images/products/tablet.svg', 'stock_quantity' => 11, 'is_available' => true, 'categories' => ['electronics', 'books']],
            ['slug' => 'smart-watch', 'name' => 'Смарт-часы', 'description' => 'Часы с уведомлениями, шагомером и контролем активности.', 'price' => 249.00, 'image' => 'images/products/smart-phone.svg', 'stock_quantity' => 19, 'is_available' => true, 'categories' => ['electronics', 'sports']],
            ['slug' => 'keyboard-mechanical', 'name' => 'Механическая клавиатура', 'description' => 'Клавиатура для комфортной работы и быстрой печати.', 'price' => 159.90, 'image' => 'images/products/laptop.svg', 'stock_quantity' => 13, 'is_available' => true, 'categories' => ['electronics', 'office']],
            ['slug' => 'shirt', 'name' => 'Рубашка', 'description' => 'Хлопковая рубашка для повседневной носки.', 'price' => 49.90, 'image' => 'images/products/shirt.svg', 'stock_quantity' => 30, 'is_available' => true, 'categories' => ['fashion']],
            ['slug' => 'sneakers', 'name' => 'Кроссовки', 'description' => 'Лёгкие кроссовки для прогулок и повседневной носки.', 'price' => 89.90, 'image' => 'images/products/sneakers.svg', 'stock_quantity' => 18, 'is_available' => true, 'categories' => ['fashion', 'sports']],
            ['slug' => 'jacket', 'name' => 'Куртка', 'description' => 'Удобная куртка на прохладную погоду.', 'price' => 129.00, 'image' => 'images/products/shirt.svg', 'stock_quantity' => 12, 'is_available' => true, 'categories' => ['fashion']],
            ['slug' => 'backpack', 'name' => 'Рюкзак', 'description' => 'Прочный городской рюкзак для работы и поездок.', 'price' => 74.50, 'image' => 'images/products/shirt.svg', 'stock_quantity' => 17, 'is_available' => true, 'categories' => ['fashion', 'office']],
            ['slug' => 'ceramic-mug', 'name' => 'Керамическая кружка', 'description' => 'Прочная кружка для кофе, чая и повседневного использования.', 'price' => 14.50, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 40, 'is_available' => true, 'categories' => ['home', 'office']],
            ['slug' => 'blender', 'name' => 'Блендер', 'description' => 'Практичный блендер для смузи и домашних блюд.', 'price' => 129.50, 'image' => 'images/products/blender.svg', 'stock_quantity' => 9, 'is_available' => true, 'categories' => ['home']],
            ['slug' => 'vacuum-cleaner', 'name' => 'Пылесос', 'description' => 'Компактный пылесос для быстрой уборки дома.', 'price' => 219.00, 'image' => 'images/products/blender.svg', 'stock_quantity' => 8, 'is_available' => true, 'categories' => ['home']],
            ['slug' => 'kettle', 'name' => 'Электрочайник', 'description' => 'Быстрый и удобный чайник для кухни.', 'price' => 39.90, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 21, 'is_available' => true, 'categories' => ['home', 'office']],
            ['slug' => 'pillow-set', 'name' => 'Набор подушек', 'description' => 'Мягкий комплект для спальни и отдыха.', 'price' => 59.00, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 14, 'is_available' => true, 'categories' => ['home']],
            ['slug' => 'yoga-mat', 'name' => 'Коврик для йоги', 'description' => 'Удобный коврик для тренировок дома и в зале.', 'price' => 34.90, 'image' => 'images/products/sneakers.svg', 'stock_quantity' => 25, 'is_available' => true, 'categories' => ['sports']],
            ['slug' => 'dumbbells', 'name' => 'Гантели', 'description' => 'Пара гантелей для домашних тренировок.', 'price' => 44.90, 'image' => 'images/products/sneakers.svg', 'stock_quantity' => 16, 'is_available' => true, 'categories' => ['sports']],
            ['slug' => 'fitness-band', 'name' => 'Фитнес-резинка', 'description' => 'Компактный аксессуар для тренировок и растяжки.', 'price' => 12.90, 'image' => 'images/products/sneakers.svg', 'stock_quantity' => 50, 'is_available' => true, 'categories' => ['sports']],
            ['slug' => 'notebook', 'name' => 'Блокнот', 'description' => 'Удобный блокнот для записей и планирования.', 'price' => 9.90, 'image' => 'images/products/tablet.svg', 'stock_quantity' => 45, 'is_available' => true, 'categories' => ['office', 'books']],
            ['slug' => 'desk-lamp', 'name' => 'Настольная лампа', 'description' => 'Лампа для комфортной работы и чтения.', 'price' => 27.50, 'image' => 'images/products/tablet.svg', 'stock_quantity' => 20, 'is_available' => true, 'categories' => ['office', 'home']],
            ['slug' => 'pen-set', 'name' => 'Набор ручек', 'description' => 'Практичный набор для учёбы и офиса.', 'price' => 7.50, 'image' => 'images/products/tablet.svg', 'stock_quantity' => 60, 'is_available' => true, 'categories' => ['office', 'books']],
            ['slug' => 'face-cream', 'name' => 'Крем для лица', 'description' => 'Нежный уход для ежедневного использования.', 'price' => 24.90, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 28, 'is_available' => true, 'categories' => ['beauty']],
            ['slug' => 'shampoo', 'name' => 'Шампунь', 'description' => 'Мягкий шампунь для регулярного ухода.', 'price' => 18.90, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 33, 'is_available' => true, 'categories' => ['beauty']],
            ['slug' => 'lip-balm', 'name' => 'Бальзам для губ', 'description' => 'Компактный бальзам для ежедневной защиты.', 'price' => 6.90, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 52, 'is_available' => true, 'categories' => ['beauty']],
            ['slug' => 'kids-backpack', 'name' => 'Детский рюкзак', 'description' => 'Лёгкий и яркий рюкзак для школы и прогулок.', 'price' => 32.90, 'image' => 'images/products/shirt.svg', 'stock_quantity' => 24, 'is_available' => true, 'categories' => ['kids']],
            ['slug' => 'kids-book', 'name' => 'Детская книга', 'description' => 'Простая и красочная книга для чтения.', 'price' => 11.50, 'image' => 'images/products/tablet.svg', 'stock_quantity' => 38, 'is_available' => true, 'categories' => ['kids', 'books']],
            ['slug' => 'teddy-bear', 'name' => 'Плюшевый мишка', 'description' => 'Мягкая игрушка для подарка и игр.', 'price' => 22.00, 'image' => 'images/products/shirt.svg', 'stock_quantity' => 27, 'is_available' => true, 'categories' => ['kids']],
            ['slug' => 'cookbook', 'name' => 'Кулинарная книга', 'description' => 'Подборка простых и вкусных рецептов.', 'price' => 19.90, 'image' => 'images/products/ceramic-mug.svg', 'stock_quantity' => 31, 'is_available' => true, 'categories' => ['books', 'home']],
            ['slug' => 'planner', 'name' => 'Планер', 'description' => 'Ежедневник для планов, задач и заметок.', 'price' => 15.90, 'image' => 'images/products/tablet.svg', 'stock_quantity' => 26, 'is_available' => true, 'categories' => ['books', 'office']],
        ];

        $productModels = [];

        foreach ($products as $productData) {
            $product = Product::query()->updateOrCreate(
                ['slug' => $productData['slug']],
                [
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'image' => $productData['image'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'is_available' => $productData['is_available'],
                ]
            );

            $product->categories()->sync(array_map(
                fn (string $slug): int => $categoryModels[$slug]->id,
                $productData['categories']
            ));

            $productModels[$productData['slug']] = $product;
        }

        $users = [
            ['email' => 'admin@admin.com', 'name' => 'admin', 'password' => 'admin', 'role' => 'admin', 'phone' => '+7 999 000-00-00'],
            ['email' => 'manager@admin.com', 'name' => 'manager', 'password' => 'manager', 'role' => 'order_manager', 'phone' => '+7 999 000-00-01'],
            ['email' => 'customer@admin.com', 'name' => 'customer', 'password' => 'customer', 'role' => 'customer', 'phone' => '+7 999 000-00-02'],
            ['email' => 'anna@example.com', 'name' => 'Анна', 'password' => 'password', 'role' => 'customer', 'phone' => '+7 914 111-22-33'],
            ['email' => 'boris@example.com', 'name' => 'Борис', 'password' => 'password', 'role' => 'customer', 'phone' => '+1 415 555-0134'],
            ['email' => 'elena@example.com', 'name' => 'Елена', 'password' => 'password', 'role' => 'customer', 'phone' => '+49 151 23456789'],
            ['email' => 'ivan@example.com', 'name' => 'Иван', 'password' => 'password', 'role' => 'customer', 'phone' => '+380 67 123 45 67'],
            ['email' => 'maria@example.com', 'name' => 'Мария', 'password' => 'password', 'role' => 'customer', 'phone' => '+998 90 123 45 67'],
            ['email' => 'oleg@example.com', 'name' => 'Олег', 'password' => 'password', 'role' => 'customer', 'phone' => '+7 922 123-45-67'],
        ];

        $userModels = [];

        foreach ($users as $userData) {
            $userModels[$userData['email']] = User::query()->updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'phone' => $userData['phone'],
                ]
            );
        }

        $orders = [
            ['email' => 'anna@example.com', 'name' => 'Анна Петрова', 'phone' => '+7 914 111-22-33', 'address' => 'Владивосток, ул. Светлая, 12', 'comment' => 'Позвонить за 20 минут до доставки.', 'items' => ['laptop' => 1, 'wireless-headphones' => 1]],
            ['email' => 'boris@example.com', 'name' => 'Борис Смирнов', 'phone' => '+1 415 555-0134', 'address' => 'San Francisco, Market Street, 45', 'comment' => 'Оставить у двери.', 'items' => ['smart-phone' => 1, 'tablet' => 1]],
            ['email' => 'elena@example.com', 'name' => 'Елена Иванова', 'phone' => '+49 151 23456789', 'address' => 'Berlin, Hauptstrasse 18', 'comment' => null, 'items' => ['shirt' => 2, 'sneakers' => 1]],
            ['email' => 'ivan@example.com', 'name' => 'Иван Кузнецов', 'phone' => '+380 67 123 45 67', 'address' => 'Киев, проспект Мира, 8', 'comment' => 'Доставка после 18:00.', 'items' => ['blender' => 1, 'ceramic-mug' => 2, 'cookbook' => 1]],
            ['email' => 'maria@example.com', 'name' => 'Мария Орлова', 'phone' => '+998 90 123 45 67', 'address' => 'Ташкент, ул. Навои, 101', 'comment' => 'Подарочная упаковка.', 'items' => ['yoga-mat' => 1, 'dumbbells' => 1, 'fitness-band' => 2]],
            ['email' => 'oleg@example.com', 'name' => 'Олег Павлов', 'phone' => '+7 922 123-45-67', 'address' => 'Хабаровск, ул. Амурская, 27', 'comment' => 'Связаться по телефону перед отправкой.', 'items' => ['notebook' => 3, 'desk-lamp' => 1, 'pen-set' => 2]],
            ['email' => 'customer@admin.com', 'name' => 'Customer Demo', 'phone' => '+7 999 000-00-02', 'address' => 'Москва, Ленинградский проспект, 10', 'comment' => 'Обычная доставка.', 'items' => ['face-cream' => 2, 'shampoo' => 1, 'lip-balm' => 4]],
            ['email' => 'anna@example.com', 'name' => 'Анна Петрова', 'phone' => '+7 914 111-22-33', 'address' => 'Владивосток, ул. Светлая, 12', 'comment' => 'Второй заказ для истории покупок.', 'items' => ['kids-backpack' => 1, 'kids-book' => 2, 'teddy-bear' => 1]],
        ];

        foreach ($orders as $index => $orderData) {
            $totalAmount = collect($orderData['items'])->reduce(function (float $carry, int $quantity, string $slug) use ($productModels): float {
                return $carry + ($quantity * (float) $productModels[$slug]->price);
            }, 0.0);

            $order = Order::query()->create([
                'user_id' => $userModels[$orderData['email']]->id,
                'total_amount' => $totalAmount,
                'status' => $index % 2 === 0 ? 'new' : 'processing',
                'customer_name' => $orderData['name'],
                'customer_phone' => $orderData['phone'],
                'customer_email' => $orderData['email'],
                'shipping_address' => $orderData['address'],
                'comment' => $orderData['comment'],
            ]);

            foreach ($orderData['items'] as $slug => $quantity) {
                $product = $productModels[$slug];

                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }
        }
    }
}
