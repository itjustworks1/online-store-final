@extends('layouts.app')

@push('styles')
    <style>
        .checkout-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 52%, #14b8a6 100%);
            color: #fff;
            border-radius: 1.5rem;
        }
        .checkout-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }
        .checkout-summary {
            position: sticky;
            top: 6.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-hero p-4 p-lg-5 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
            <div>
                <span class="badge rounded-pill text-bg-light text-dark mb-3 px-3 py-2">Оформление заказа</span>
                <h1 class="display-6 fw-bold mb-2">Данные для доставки</h1>
                <p class="mb-0 text-white-50">Заполните контактную информацию и подтвердите заказ в одном шаге.</p>
            </div>
            <div class="px-3 py-2 rounded-3 bg-white text-dark">
                <div class="small text-muted">Сумма корзины</div>
                <div class="h4 fw-bold mb-0">{{ number_format((float) $total, 2, '.', ' ') }} ₽</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card checkout-card shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <form method="POST" action="{{ route('checkout.store') }}" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Имя</label>
                            <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name ?? '') }}" class="form-control @error('customer_name') is-invalid @enderror" required>
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Телефон</label>
                            <input id="customer_phone" type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()?->phone ?? '') }}" class="form-control @error('customer_phone') is-invalid @enderror" placeholder="+7 999 123-45-67" required>
                            @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="customer_email" class="form-label">Email</label>
                            <input id="customer_email" type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email ?? '') }}" class="form-control @error('customer_email') is-invalid @enderror" required>
                            @error('customer_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="shipping_address" class="form-label">Адрес доставки</label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="comment" class="form-label">Комментарий</label>
                            <textarea id="comment" name="comment" rows="3" class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
                            @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg">Подтвердить заказ</button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg ms-2">Вернуться в корзину</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card checkout-summary p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 fw-bold mb-0">Ваш заказ</h2>
                    <span class="badge rounded-pill text-bg-dark">{{ $items->count() }} поз.</span>
                </div>

                <div class="vstack gap-3">
                    @foreach ($items as $item)
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <div class="fw-semibold">{{ $item['product']->name }}</div>
                                <div class="text-muted small">{{ $item['quantity'] }} шт. x {{ number_format((float) $item['product']->price, 2, '.', ' ') }} ₽</div>
                            </div>
                            <div class="fw-semibold text-primary">{{ number_format((float) $item['subtotal'], 2, '.', ' ') }} ₽</div>
                        </div>
                    @endforeach
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Итого</span>
                    <span class="h4 fw-bold mb-0">{{ number_format((float) $total, 2, '.', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>
@endsection
