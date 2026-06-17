<x-guest-layout>
    <div class="auth-shell">
        <div class="auth-backdrop"></div>
        <div class="container py-5 position-relative">
            <div class="row align-items-center g-4 g-lg-5 min-vh-100 py-4">
                <div class="col-lg-6 text-white">
                    <div class="pe-lg-5">
                        <span class="badge rounded-pill text-bg-light text-dark mb-4 px-3 py-2">Only Store</span>
                        <h1 class="display-4 fw-bold lh-1 mb-4">Онлайн-магазин с удобным каталогом и быстрым поиском.</h1>
                        <p class="lead text-white-75 mb-4">
                            Выбирайте товары для дома, одежды и техники в одном месте.
                            Понятные категории, свежие предложения и простой вход в аккаунт.
                        </p>

                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <div class="feature-pill">
                                <strong>Каталог</strong>
                                <span>Товары по категориям и удобный поиск</span>
                            </div>
                            <div class="feature-pill">
                                <strong>Покупки</strong>
                                <span>Быстрый доступ к товарам и описаниям</span>
                            </div>
                            <div class="feature-pill">
                                <strong>Удобство</strong>
                                <span>Простой вход без лишних шагов</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="auth-card card border-0 shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-4">
                                <p class="text-uppercase text-muted small fw-semibold mb-2">Вход в систему</p>
                                <h2 class="h3 fw-bold mb-2">Добро пожаловать обратно</h2>
                                <p class="text-muted mb-0">Войдите, чтобы продолжить покупки или управлять магазином.</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger border-0">
                                    Проверьте email и пароль.
                                </div>
                            @endif

                            <x-auth-session-status class="mb-3" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}" class="vstack gap-3">
                                @csrf

                                <div>
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        class="form-control form-control-lg"
                                        placeholder="name@example.com"
                                    >
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="form-label fw-semibold">Пароль</label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="form-control form-control-lg"
                                        placeholder="Введите пароль"
                                    >
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <label class="form-check-label d-flex align-items-center gap-2">
                                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                        <span class="text-muted">Запомнить меня</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a class="text-decoration-none small fw-semibold" href="{{ route('password.request') }}">
                                            Забыли пароль?
                                        </a>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-dark btn-lg w-100">
                                    Войти
                                </button>
                            </form>

                            <div class="divider my-4"></div>

                            <div class="small text-muted">
                                <div class="fw-semibold mb-1">Подсказка</div>
                                Бог любит яблоки
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
