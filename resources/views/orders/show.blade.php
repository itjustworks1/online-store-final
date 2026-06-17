@extends('layouts.app')

@push('styles')
    <style>
        .order-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 52%, #14b8a6 100%);
            color: #fff;
            border-radius: 1.5rem;
        }
        .order-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="mb-3">
        <a href="{{ route('orders.my') }}" class="btn btn-outline-secondary">← Назад к заказам</a>
    </div>

    <div class="order-hero p-4 p-lg-5 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
            <div>
                <span class="badge rounded-pill text-bg-light text-dark mb-3 px-3 py-2">Заказ №{{ $order->id }}</span>
                <h1 class="display-6 fw-bold mb-2">{{ $order->customer_name }}</h1>
                <p class="mb-0 text-white-50">{{ $order->customer_email }} · {{ $order->customer_phone }}</p>
            </div>
            <div class="px-3 py-2 rounded-3 bg-white text-dark">
                <div class="small text-muted">Сумма</div>
                <div class="h4 fw-bold mb-0">{{ number_format((float) $order->total_amount, 2, '.', ' ') }} ₽</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card order-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 fw-bold mb-0">Состав заказа</h2>
                        @php
                            $statusLabel = match ($order->status) {
                                'processing' => 'В обработке',
                                'shipped' => 'Отправлен',
                                'delivered' => 'Доставлен',
                                'cancelled' => 'Отменён',
                                default => 'Новый',
                            };
                            $statusClass = match ($order->status) {
                                'processing' => 'bg-warning text-dark',
                                'shipped' => 'bg-primary',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-info text-dark',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="vstack gap-3">
                        @foreach ($order->orderItems as $item)
                            <div class="d-flex justify-content-between gap-3 p-3 rounded-4 bg-light">
                                <div>
                                    <div class="fw-semibold">{{ $item->product?->name ?? 'Товар' }}</div>
                                    <div class="text-muted small">{{ $item->quantity }} шт. x {{ number_format((float) $item->price, 2, '.', ' ') }} ₽</div>
                                </div>
                                <div class="fw-bold text-primary">{{ number_format((float) $item->price * $item->quantity, 2, '.', ' ') }} ₽</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card p-4 shadow-sm">
                <h2 class="h4 fw-bold mb-3">Доставка</h2>
                <div class="mb-3">
                    <div class="text-uppercase text-muted small">Адрес</div>
                    <div>{{ $order->shipping_address }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-uppercase text-muted small">Комментарий</div>
                    <div>{{ $order->comment ?: 'Нет комментария' }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-uppercase text-muted small">Дата</div>
                    <div>{{ optional($order->created_at)->format('d.m.Y H:i') }}</div>
                </div>
                <div class="mb-0">
                    <div class="text-uppercase text-muted small">Плательщик</div>
                    <div>{{ $order->user?->name ?? 'Гость' }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
