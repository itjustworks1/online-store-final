<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if($product != null)
                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">название</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">описание</label>
                                <textarea type="text" class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">ссылка на изображение</label>
                                <input type="text" name="image" value="{{ old('image') }}" >
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">цена</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">колличество</label>
                                <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                            </div>
                            <div class="mb-3">
                                <input id="remember_me" type="checkbox" class="rounded" name="remember" value="{{ old('is_available') }}">
                                <span class="ms-2 text-sm">{{ __('доступность для покупки') }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary">Создать</button>
                            {{--                        <a href=" {{route('admin.products.create')}} ">добавить</a>--}}
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="title" class="form-label">название</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">описание</label>
                                <textarea type="text" class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">цена</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">колличество</label>
                                <input type="text" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                            </div>
                            <div class="mb-3">
                                <input id="remember_me" type="checkbox" class="rounded" name="remember" value="{{ old('is_available') }}">
                                <span class="ms-2 text-sm">{{ __('доступность для покупки') }}</span>
                            </div>
                        <button type="submit" class="btn btn-primary">Изменить</button>
                        <a href=" {{route('admin.products.delete')}} ">Удалить</a>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
