@php
    $layout = (($useAdminLayout ?? false) ? 'admin-layout' : 'app-layout');
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #0f172a 0%, #334155 55%, #1d4ed8 100%); color: #fff;">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-lg-center">
                    <div>
                        <span class="badge rounded-pill text-bg-light text-dark mb-3 px-3 py-2">Профиль</span>
                        <h1 class="display-6 fw-bold mb-2">Настройки аккаунта</h1>
                        <p class="mb-0 text-white-50">
                            Обновляйте имя, телефон, пароль и параметры безопасности.
                        </p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @if(($useAdminLayout ?? false))
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg">Админ-панель</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-lg">Главное меню</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm mt-3">
            {{ session('status') === 'profile-updated' ? 'Профиль сохранён.' : (session('status') === 'password-updated' ? 'Пароль обновлён.' : session('status')) }}
        </div>
    @endif

    <div class="row g-4 mt-1">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h2 class="h4 fw-bold mb-1">Личные данные</h2>
                            <div class="text-muted">Имя, email и телефон для связи</div>
                        </div>
                        <span class="badge text-bg-primary">Аккаунт</span>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="row g-3">
                        @csrf
                        @method('patch')

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Имя</label>
                            <input id="name" name="name" type="text" class="form-control form-control-lg" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Телефон</label>
                            <input id="phone" name="phone" type="tel" class="form-control form-control-lg" value="{{ old('phone', $user->phone) }}" placeholder="+7 999 123-45-67">
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input id="email" name="email" type="email" class="form-control form-control-lg" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-3 pt-2">
                            <button type="submit" class="btn btn-dark btn-lg">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="vstack gap-4 h-100">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <div class="mb-3">
                            <h2 class="h4 fw-bold mb-1">Смена пароля</h2>
                            <div class="text-muted">Используйте надёжный пароль для защиты аккаунта</div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="vstack gap-3">
                            @csrf
                            @method('put')

                            <div>
                                <label for="current_password" class="form-label fw-semibold">Текущий пароль</label>
                                <input id="current_password" name="current_password" type="password" class="form-control form-control-lg" autocomplete="current-password">
                                @error('current_password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="form-label fw-semibold">Новый пароль</label>
                                <input id="password" name="password" type="password" class="form-control form-control-lg" autocomplete="new-password">
                                @error('password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="form-label fw-semibold">Подтвердите пароль</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control form-control-lg" autocomplete="new-password">
                            </div>

                            <div>
                                <button type="submit" class="btn btn-outline-dark btn-lg">Обновить пароль</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <div class="mb-3">
                            <h2 class="h4 fw-bold mb-1 text-danger">Удаление аккаунта</h2>
                            <div class="text-muted">Данные удаляются без возможности восстановления</div>
                        </div>

                        <button class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Удалить аккаунт
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title">Подтвердите удаление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            Введите пароль, чтобы окончательно удалить аккаунт.
                        </p>
                        <label for="delete_password" class="form-label fw-semibold">Пароль</label>
                        <input id="delete_password" name="password" type="password" class="form-control form-control-lg" required>
                        @error('password', 'userDeletion')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dynamic-component>
