<x-admin-layout>
    <x-slot name="header">
        <div class="admin-hero p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
                <div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="admin-chip">Управление заказами</span>
                        <span class="admin-chip">{{ $orders->count() }} заказов</span>
                    </div>
                    <h1 class="display-6 fw-bold mb-2 admin-section-title">Заказы магазина</h1>
                    <p class="mb-0 text-white-50">
                        Просматривайте клиентов, суммы и состав заказов без лишнего шума.
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg">Панель</a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning btn-lg">Товары</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="admin-card p-4">
        <div class="table-responsive">
            <table class="table admin-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Клиент</th>
                        <th>Контакты</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Товаров</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->id }}</td>
                            <td>{{ $order->customer_name ?? $order->user?->name ?? 'Без имени' }}</td>
                            <td>
                                <div class="small">{{ $order->customer_email ?? $order->user?->email ?? 'Нет email' }}</div>
                                <div class="small text-white-50">{{ $order->customer_phone ?? 'Нет телефона' }}</div>
                            </td>
                            <td class="fw-semibold">{{ number_format((float) $order->total_amount, 0, ',', ' ') }} ₽</td>
                            <td><span class="badge text-bg-info text-dark">{{ $order->status ?? 'new' }}</span></td>
                            <td>{{ $order->order_items->count() }}</td>
                            <td>{{ optional($order->created_at)->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="pt-0">
                                <div class="p-3 rounded-4" style="background: rgba(148, 163, 184, 0.08); border: 1px solid rgba(148, 163, 184, 0.12);">
                                    <div class="small text-white-50 mb-2">Состав заказа</div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @forelse ($order->order_items as $item)
                                            <span class="badge text-bg-secondary">
                                                {{ $item->product?->name ?? 'Товар' }} × {{ $item->quantity ?? 1 }}
                                            </span>
                                        @empty
                                            <span class="text-white-50">Позиции не найдены</span>
                                        @endforelse
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-white-50 py-4">Пока нет заказов</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
