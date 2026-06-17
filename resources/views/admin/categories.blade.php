<x-admin-layout>
    <x-slot name="header">
        <div class="admin-hero p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
                <div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="admin-chip">Управление категориями</span>
                        <span class="admin-chip">{{ $category->exists ? 'Редактирование' : 'Создание' }}</span>
                    </div>
                    <h1 class="display-6 fw-bold mb-2 admin-section-title">
                        Категории магазина
                    </h1>
                    <p class="mb-0 text-white-50">Создание, редактирование и удаление категорий.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg">Панель</a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning btn-lg">Товары</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row g-4">
        <div class="col-xl-5">
            <div class="admin-card p-4 h-100">
                @if (($viewMode ?? 'create') === 'view')
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h4 fw-semibold mb-1">Просмотр категории</h2>
                            <div class="admin-soft">Карточка без формы редактирования</div>
                        </div>
                        <span class="badge text-bg-success">ID {{ $category->id }}</span>
                    </div>

                    <div class="vstack gap-3">
                        <div>
                            <div class="text-white-50 small">Название</div>
                            <div class="fw-semibold">{{ $category->name }}</div>
                        </div>
                        <div>
                            <div class="text-white-50 small">Slug</div>
                            <span class="badge text-bg-secondary">{{ $category->slug }}</span>
                        </div>
                        <div>
                            <div class="text-white-50 small">Описание</div>
                            <div>{{ $category->description ?: 'Без описания' }}</div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 pt-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-lg">Править</a>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light btn-lg">К списку</a>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h4 fw-semibold mb-1">{{ $category->exists ? 'Изменить категорию' : 'Новая категория' }}</h2>
                            <div class="admin-soft">Имя и описание категории</div>
                        </div>
                        @if ($category->exists)
                            <span class="badge text-bg-success">ID {{ $category->id }}</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="vstack gap-3">
                        @csrf
                        @if ($category->exists)
                            @method('PATCH')
                        @endif

                        <div>
                            <label for="name" class="form-label">Название</label>
                            <input id="name" name="name" type="text" class="form-control admin-input" value="{{ old('name', $category->name) }}" required>
                        </div>

                        <div>
                            <label for="description" class="form-label">Описание</label>
                            <textarea id="description" name="description" rows="5" class="form-control admin-textarea">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2 pt-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                {{ $category->exists ? 'Сохранить' : 'Создать' }}
                            </button>
                        </div>
                    </form>

                    @if ($category->exists)
                        <form class="mt-3" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Удалить категорию?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-light btn-lg">Удалить</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="col-xl-7">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 fw-semibold mb-1">Список категорий</h2>
                        <div class="admin-soft">Все категории</div>
                    </div>
                    <span class="badge text-bg-info text-dark">{{ $categories->count() }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table admin-table align-middle">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Slug</th>
                                <th>Описание</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item->name }}</td>
                                    <td><span class="badge text-bg-secondary">{{ $item->slug }}</span></td>
                                    <td class="text-white-50">{{ $item->description ?: 'Без описания' }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.categories.show', $item) }}" class="btn btn-outline-light">Открыть</a>
                                            <a href="{{ route('admin.categories.edit', $item) }}" class="btn btn-outline-info">Править</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-white-50 py-4">Категорий пока нет</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
