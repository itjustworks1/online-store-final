@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="card filter-card sticky-lg-top" style="top: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Фильтры</p>
                            <h1 class="h5 mb-0 section-title">Каталог товаров</h1>
                        </div>
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">{{ $products->total() }}</span>
                    </div>

                    <form method="GET" action="{{ route('products.index') }}" class="vstack gap-3">
                        <div>
                            <label for="search" class="form-label fw-semibold">Поиск</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">⌕</span>
                                <input type="search" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="Название или описание">
                            </div>
                        </div>

                        <div>
                            <label for="category" class="form-label fw-semibold">Категория</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Все категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="sort" class="form-label fw-semibold">Сортировка</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest" @selected($sort === 'newest')>Сначала новые</option>
                                <option value="oldest" @selected($sort === 'oldest')>Сначала старые</option>
                                <option value="price_asc" @selected($sort === 'price_asc')>Цена: по возрастанию</option>
                                <option value="price_desc" @selected($sort === 'price_desc')>Цена: по убыванию</option>
                                <option value="name_asc" @selected($sort === 'name_asc')>Название: А-Я</option>
                                <option value="name_desc" @selected($sort === 'name_desc')>Название: Я-А</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">Применить</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Сброс</a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products.index', request()->except('category', 'page')) }}"
                           class="btn btn-sm catalog-chip {{ $activeCategory === null ? 'btn-dark' : 'btn-outline-dark' }}">
                            Все товары
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                               class="btn btn-sm catalog-chip {{ $activeCategory?->id === $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        <section class="col-lg-9">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Каталог</p>
                    <h2 class="display-6 fw-bold section-title mb-0">Товары для витрины</h2>
                </div>
                <div class="d-flex gap-2">
                    <div class="px-3 py-2 rounded-3 bg-white border">
                        <div class="text-muted small">Товаров</div>
                        <div class="fw-semibold">{{ $products->total() }}</div>
                    </div>
                    <div class="px-3 py-2 rounded-3 bg-white border">
                        <div class="text-muted small">Категорий</div>
                        <div class="fw-semibold">{{ $categories->count() }}</div>
                    </div>
                </div>
            </div>

            @if ($activeCategory)
                <div class="alert alert-info border-0 shadow-sm">
                    Показаны товары категории: <strong>{{ $activeCategory->name }}</strong>
                </div>
            @endif

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-6 col-xl-4">
                        <div class="card catalog-card product-card h-100 overflow-hidden">
                            <div class="position-relative image-shell">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @else
                                    <div class="product-image d-flex align-items-center justify-content-center text-muted">
                                        Нет изображения
                                    </div>
                                @endif
                                <div class="position-absolute top-0 start-0 p-3 d-flex gap-2 flex-wrap">
                                    <span class="badge rounded-pill {{ $product->is_available ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->is_available ? 'В наличии' : 'Нет в наличии' }}
                                    </span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 end-0 p-3">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <span class="badge rounded-pill price-badge px-3 py-2">
                                            {{ number_format($product->price, 2, '.', ' ') }} ₽
                                        </span>
                                        <span class="badge rounded-pill bg-white text-dark border">
                                            {{ $product->categories->count() }} катег.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h3 class="h5 mb-0 section-title lh-sm">{{ $product->name }}</h3>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge rounded-pill soft-badge">
                                        На складе: {{ $product->stock_quantity }}
                                    </span>
                                    <span class="badge rounded-pill soft-badge">
                                        {{ $product->categories->pluck('name')->join(', ') ?: 'Без категории' }}
                                    </span>
                                </div>

                                <p class="text-muted small flex-grow-1 mb-3 lh-base">
                                    {{ \Illuminate\Support\Str::limit($product->description, 110) }}
                                </p>

                                <div class="mb-3 d-flex flex-wrap gap-2">
                                    @foreach ($product->categories as $category)
                                        <span class="badge rounded-pill text-bg-light border">{{ $category->name }}</span>
                                    @endforeach
                                </div>

                                <form method="POST" action="{{ route('cart.add', $product) }}" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary w-100" @disabled(! $product->is_available || $product->stock_quantity <= 0)>
                                        {{ $product->is_available && $product->stock_quantity > 0 ? 'В корзину' : 'Недоступен' }}
                                    </button>
                                </form>

                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning border-0 shadow-sm mb-0">Товары не найдены.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </section>
    </div>
@endsection
