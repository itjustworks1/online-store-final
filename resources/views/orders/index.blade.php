@extends('layouts.app')

@push('styles')
    <style>
        .orders-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 52%, #14b8a6 100%);
            color: #fff;
            border-radius: 1.5rem;
        }
        .order-item-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="orders-hero p-4 p-lg-5 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
            <div>
                <span class="badge rounded-pill text-bg-light text-dark mb-3 px-3 py-2">Мои заказы</span>
                <h1 class="display-6 fw-bold mb-2">История покупок</h1>
                <p class="mb-0 text-white-50">Здесь хранятся оформленные вами заказы и их текущие статусы.</p>
            </div>
            <div class="px-3 py-2 rounded-3 bg-white text-dark">
                <div class="small text-muted">Всего заказов</div>
                <div class="h4 fw-bold mb-0">{{ $orders->count() }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($orders as $order)
            <div class="col-12">
                <div class="card order-item-card">
                    <div class="card-body p-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-3">
                                <div class="text-uppercase text-muted small mb-1">Заказ №{{ $order->id }}</div>
                                <div class="h5 fw-bold mb-1">{{ $order->customer_name }}</div>
                                <div class="text-muted small">{{ optional($order->created_at)->format('d.m.Y H:i') }}</div>
                            </div>
                            <div class="col-lg-3">
                                <div class="text-uppercase text-muted small mb-1">Статус</div>
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
                            <div class="col-lg-2">
                                <div class="text-uppercase text-muted small mb-1">Сумма</div>
                                <div class="fw-bold">{{ number_format((float) $order->total_amount, 2, '.', ' ') }} ₽</div>
                            </div>
                            <div class="col-lg-2">
                                <div class="text-uppercase text-muted small mb-1">Позиции</div>
                                <div class="fw-bold">{{ $order->orderItems->count() }}</div>
                            </div>
                            <div class="col-lg-2 text-lg-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary">Открыть</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm mb-0">
                    Пока у вас нет заказов. После оформления они появятся здесь.
                </div>
            </div>
        @endforelse
    </div>
@endsection
