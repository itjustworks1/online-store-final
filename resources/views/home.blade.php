<x-app-layout>
    <x-slot name="header">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 52%, #14b8a6 100%); color: #fff;">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
                    <div class="pe-lg-5">
                        <span class="badge rounded-pill text-bg-light text-dark mb-3 px-3 py-2">Only Store</span>
                        <h1 class="display-5 fw-bold mb-3">Главное меню покупателя</h1>
                        <p class="lead text-white-50 mb-0">
                            Здесь собраны каталог, профиль и быстрые переходы к покупкам. Всё без лишних кликов.
                        </p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">Открыть каталог</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-lg">Профиль</a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row g-4 mt-1 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="text-muted mb-2">Товары</div>
                    <div class="display-6 fw-bold">{{ $products->count() }}</div>
                    <div class="text-muted">Актуальные позиции в каталоге</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="text-muted mb-2">Профиль</div>
                    <div class="display-6 fw-bold">1 клик</div>
                    <div class="text-muted">Быстрый доступ к настройкам аккаунта</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="text-muted mb-2">Навигация</div>
                    <div class="display-6 fw-bold">Удобно</div>
                    <div class="text-muted">Каталог, поиск и карточки товаров</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h2 class="h3 fw-bold mb-1">Популярные товары</h2>
            <div class="text-muted">Выберите товар и перейдите к подробностям</div>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Перейти в каталог</a>
    </div>

    <div class="row g-4">
        @forelse($products->take(6) as $product)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 product-card">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="h5 fw-bold mb-1">{{ $product->name }}</h3>
                                <div class="text-muted small">Остаток: {{ $product->stock_quantity }} шт.</div>
                            </div>
                            <span class="badge text-bg-dark">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</span>
                        </div>

                        <p class="text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $product->is_available ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $product->is_available ? 'Доступен' : 'Нет в продаже' }}
                            </span>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm mb-0">Пока нет товаров в каталоге.</div>
            </div>
        @endforelse
    </div>
</x-app-layout>
