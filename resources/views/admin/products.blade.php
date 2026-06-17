<x-admin-layout>
    <x-slot name="header">
        <div class="admin-hero p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
                <div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="admin-chip">Управление товарами</span>
                        <span class="admin-chip">{{ $product->exists ? 'Редактирование' : 'Создание' }}</span>
                    </div>
                    <h1 class="display-6 fw-bold mb-2 admin-section-title">
                        {{ $product->exists ? 'Редактирование товара' : 'Добавить новый товар' }}
                    </h1>
                    <p class="mb-0 text-white-50">
                        Аккуратная карточка товара с формой и быстрым списком каталога.
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg">Панель</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-lg">Заказы</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row g-4">
        <div class="col-xl-5">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 fw-semibold mb-1">{{ $product->exists ? 'Изменить товар' : 'Новый товар' }}</h2>
                        <div class="admin-soft">Заполните поля и сохраните изменения</div>
                    </div>
                    @if ($product->exists)
                        <span class="badge text-bg-success">ID {{ $product->id }}</span>
                    @endif
                </div>

                <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="vstack gap-3">
                    @csrf
                    @if ($product->exists)
                        @method('PATCH')
                    @endif

                    <div>
                        <label for="name" class="form-label">Название</label>
                        <input id="name" name="name" type="text" class="form-control admin-input" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div>
                        <label for="description" class="form-label">Описание</label>
                        <textarea id="description" name="description" rows="5" class="form-control admin-textarea" required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div>
                        <label for="image" class="form-label">Ссылка на изображение</label>
                        <input id="image" name="image" type="url" class="form-control admin-input" value="{{ old('image', $product->image) }}" placeholder="https://...">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Цена</label>
                            <input id="price" name="price" type="number" step="0.01" class="form-control admin-input" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stock_quantity" class="form-label">Количество</label>
                            <input id="stock_quantity" name="stock_quantity" type="number" class="form-control admin-input" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        </div>
                    </div>

                    <div class="form-check">
                        <input id="is_available" type="checkbox" class="form-check-input" name="is_available" value="1" @checked(old('is_available', $product->is_available))>
                        <label class="form-check-label" for="is_available">Доступен для покупки</label>
                    </div>

                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            {{ $product->exists ? 'Сохранить' : 'Создать' }}
                        </button>
                    </div>
                </form>

                @if ($product->exists)
                    <form class="mt-3" method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Удалить товар?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-light btn-lg">Удалить</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="col-xl-7">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 fw-semibold mb-1">Каталог товаров</h2>
                        <div class="admin-soft">Быстрый доступ к редактированию и удалению</div>
                    </div>
                    <span class="badge text-bg-info text-dark">{{ $products->count() }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table admin-table align-middle">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Остаток</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->name }}</div>
                                        <div class="small text-white-50 text-truncate" style="max-width: 280px;">{{ $item->description }}</div>
                                    </td>
                                    <td>{{ number_format((float) $item->price, 0, ',', ' ') }} ₽</td>
                                    <td>{{ $item->stock_quantity }}</td>
                                    <td>
                                        <span class="badge {{ $item->is_available ? 'text-bg-success' : 'text-bg-secondary' }}">
                                            {{ $item->is_available ? 'В продаже' : 'Скрыт' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.products.show', $item) }}" class="btn btn-outline-light">Открыть</a>
                                            <a href="{{ route('admin.products.edit', $item) }}" class="btn btn-outline-info">Править</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-white-50 py-4">Товаров пока нет</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
