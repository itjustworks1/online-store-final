<x-admin-layout>
    <x-slot name="header">
        <div class="admin-hero p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
                <div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="admin-chip">Админ-панель</span>
                        <span class="admin-chip">Only Store</span>
                    </div>
                    <h1 class="display-6 fw-bold mb-2 admin-section-title">Панель управления магазином</h1>
                    <p class="mb-0 text-white-50">Панель управления магазином.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning btn-lg">Товары</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-lg">Заказы</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="admin-card admin-stat p-4 h-100">
                <div class="text-white-50 mb-2">Товаров</div>
                <div class="display-5 fw-bold">{{ $count_product }}</div>
                <div class="admin-soft mt-2">Всего товаров в каталоге</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card admin-stat p-4 h-100">
                <div class="text-white-50 mb-2">Заказов</div>
                <div class="display-5 fw-bold">{{ $count_order }}</div>
                <div class="admin-soft mt-2">Оформлено покупателями</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card admin-stat p-4 h-100">
                <div class="text-white-50 mb-2">Пользователей</div>
                <div class="display-5 fw-bold">{{ $count_user }}</div>
                <div class="admin-soft mt-2">Зарегистрировано в системе</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 fw-semibold mb-1">Последние заказы</h2>
                        <div class="admin-soft">Пять последних оформленных заказов</div>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-sm">Все заказы</a>
                </div>
                <div class="table-responsive">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Клиент</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($last_orders as $last_order)
                                <tr>
                                    <td class="fw-semibold">{{ $last_order->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $last_order->customer_name ?? $last_order->user?->name ?? 'Без имени' }}</div>
                                        <div class="small text-white-50">{{ $last_order->customer_email ?? $last_order->user?->email ?? 'Нет email' }}</div>
                                    </td>
                                    <td>{{ number_format((float) $last_order->total_amount, 0, ',', ' ') }} ₽</td>
                                    <td>
                                        <span class="badge text-bg-info text-dark">{{ $last_order->status ?? 'new' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-white-50 py-4">Пока нет заказов</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 fw-semibold mb-1">Низкий остаток</h2>
                        <div class="admin-soft">Товары, которые пора пополнить</div>
                    </div>
                    <span class="badge text-bg-warning text-dark">{{ $products->count() }}</span>
                </div>

                <div class="vstack gap-3">
                    @forelse ($products as $product)
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-4" style="background: rgba(148, 163, 184, 0.08); border: 1px solid rgba(148, 163, 184, 0.12);">
                            <div>
                                <div class="fw-semibold">{{ $product->name }}</div>
                                <div class="small text-white-50">Остаток: {{ $product->stock_quantity }} шт.</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</div>
                                <a href="{{ route('admin.products.show', $product) }}" class="small text-info text-decoration-none">Открыть</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-white-50">Нет товаров с низким остатком.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
