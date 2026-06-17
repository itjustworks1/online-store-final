@extends('layouts.app')

@push('styles')
    <style>
        .cart-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 52%, #14b8a6 100%);
            color: #fff;
            border-radius: 1.5rem;
        }
        .cart-line {
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        }
        .cart-line:last-child {
            border-bottom: 0;
        }
        .cart-thumb {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: 1rem;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }
        .qty-input {
            max-width: 110px;
        }
        .cart-summary {
            position: sticky;
            top: 6.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="cart-hero p-4 p-lg-5 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
            <div>
                <span class="badge rounded-pill text-bg-light text-dark mb-3 px-3 py-2">Корзина</span>
                <h1 class="display-6 fw-bold mb-2">Позиции выбранных товаров</h1>
                <p class="mb-0 text-white-50">Корзина и оформление заказа готовы к работе.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <div class="px-3 py-2 rounded-3 bg-white text-dark">
                    <div class="small text-muted">Позиций</div>
                    <div class="fw-bold">{{ $items->count() }}</div>
                </div>
                <div class="px-3 py-2 rounded-3 bg-white text-dark">
                    <div class="small text-muted">Товаров</div>
                    <div class="fw-bold">{{ $count }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card cart-card border-0 shadow-sm">
                <div class="card-body p-0">
                    @forelse ($items as $item)
                        @php($identifier = $item['identifier'])
                        <div class="cart-line p-3 p-lg-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-2">
                                    @if ($item['product']->image_url)
                                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="cart-thumb w-100">
                                    @else
                                        <div class="cart-thumb w-100 d-flex align-items-center justify-content-center text-muted">Нет фото</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h2 class="h5 mb-1">{{ $item['product']->name }}</h2>
                                    <div class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($item['product']->description, 90) }}</div>
                                    <span class="badge rounded-pill text-bg-light border">Остаток: {{ $item['product']->stock_quantity }}</span>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-uppercase text-muted small mb-1">Цена</div>
                                    <div class="fw-semibold">{{ number_format((float) $item['product']->price, 2, '.', ' ') }} ₽</div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-uppercase text-muted small mb-1">Сумма</div>
                                    <div class="fw-bold text-primary">{{ number_format((float) $item['subtotal'], 2, '.', ' ') }} ₽</div>
                                </div>
                                <div class="col-md-2">
                                    <form method="POST" action="{{ route('cart.update', $identifier) }}" class="d-flex flex-column gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number"
                                               name="quantity"
                                               min="1"
                                               max="{{ $item['product']->stock_quantity }}"
                                               value="{{ $item['quantity'] }}"
                                               class="form-control qty-input">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Обновить</button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-end">
                                <form method="POST" action="{{ route('cart.remove', $identifier) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center">
                            <div class="display-6 mb-2">Корзина пуста</div>
                            <p class="text-muted mb-4">Добавьте товары из каталога, чтобы собрать заказ.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Перейти в каталог</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card cart-summary p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 fw-bold mb-0">Итого</h2>
                    <span class="badge rounded-pill text-bg-dark">{{ $count }} шт.</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Сумма заказа</span>
                    <span class="h4 fw-bold mb-0">{{ number_format((float) $total, 2, '.', ' ') }} ₽</span>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ $items->isEmpty() ? '#' : route('checkout') }}"
                       class="btn btn-primary btn-lg {{ $items->isEmpty() ? 'disabled' : '' }}"
                       @if ($items->isEmpty()) aria-disabled="true" tabindex="-1" @endif>
                        Оформить заказ
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Продолжить покупки</a>
                </div>
            </div>
        </div>
    </div>
@endsection
