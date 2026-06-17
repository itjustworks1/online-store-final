@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('products.index', request()->except('page')) }}" class="btn btn-outline-secondary">
            ← Назад в каталог
        </a>
    </div>

    <div class="card detail-card overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-lg-6 image-shell">
                @if ($product->image_url)
                    <img src="{{ $product->image_url }}" class="img-fluid w-100 product-image detail bg-white" alt="{{ $product->name }}">
                @else
                    <div class="product-image detail d-flex align-items-center justify-content-center text-muted">
                        Нет изображения
                    </div>
                @endif
                <div class="position-absolute top-0 start-0 p-4 d-flex gap-2 flex-wrap">
                    <span class="badge rounded-pill {{ $product->is_available ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                        {{ $product->is_available ? 'В наличии' : 'Нет в наличии' }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body p-4 p-lg-5 info-panel h-100 d-flex flex-column">
                    <div class="mb-3">
                        <p class="text-uppercase text-muted small mb-1">Карточка товара</p>
                        <h1 class="display-6 fw-bold section-title mb-3">{{ $product->name }}</h1>
                        <p class="text-muted mb-0">{{ $product->description }}</p>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge rounded-pill price-badge px-3 py-2 fs-6">
                            {{ number_format($product->price, 2, '.', ' ') }} ₽
                        </span>
                        <span class="badge rounded-pill soft-badge px-3 py-2 stat-pill">
                            На складе: {{ $product->stock_quantity }}
                        </span>
                        <span class="badge rounded-pill soft-badge px-3 py-2 stat-pill">
                            Категорий: {{ $product->categories->count() }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <div class="text-uppercase text-muted small fw-semibold mb-2">Категории</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($product->categories as $category)
                                <span class="badge rounded-pill text-bg-light border">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="p-3 rounded-4 bg-white border">
                            <div class="text-uppercase text-muted small fw-semibold mb-2">О товаре</div>
                            <p class="mb-0 text-muted">
                                Этот товар можно добавлять в корзину, фильтровать по категориям и использовать как часть витрины каталога.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($relatedProducts->isNotEmpty())
        <div class="d-flex align-items-end justify-content-between gap-3 mb-3">
            <h2 class="h4 fw-bold section-title mb-0">Похожие товары</h2>
        </div>

        <div class="row g-4">
            @foreach ($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-xl-3">
                    <div class="card catalog-card product-card h-100 overflow-hidden">
                        <div class="position-relative image-shell">
                            @if ($relatedProduct->image_url)
                                <img src="{{ $relatedProduct->image_url }}" class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
                            @else
                                <div class="product-image d-flex align-items-center justify-content-center text-muted">
                                    Нет изображения
                                </div>
                            @endif
                            <div class="position-absolute top-0 start-0 p-3">
                                <span class="badge rounded-pill bg-light text-dark border">
                                    {{ number_format($relatedProduct->price, 2, '.', ' ') }} ₽
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <h3 class="h6 mb-2">{{ $relatedProduct->name }}</h3>
                            <p class="text-muted small flex-grow-1 mb-3">
                                {{ \Illuminate\Support\Str::limit($relatedProduct->description, 80) }}
                            </p>
                            <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-sm btn-outline-primary w-100">Открыть</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
