@vite(['resources/css/app.css','resources/css/global.css', 'resources/css/header_styles.css'])
<header class="bg-teal-700 text-white shadow-lg">
    
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a href="{{ route('toms.index') }}" class="navbar-brand text-xl font-bold title">Людина-Табурет</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('toms.index') }}" class="nav-link hover:text-teal-200">Томи</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link hover:text-teal-200">
                                <span class="relative">
                                    Кошик
                                    @if(auth()->user()->toms->count() > 0)
                                        <span class="badge bg-danger ms-1">{{ auth()->user()->toms->sum('pivot.quantity') }}</span>
                                    @endif
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" class="nav-link hover:text-teal-200">Мої замовлення</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link hover:text-teal-200">Вийти</button>
                            </form>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link hover:text-teal-200">Увійти</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link hover:text-teal-200">Зареєструватися</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

</header>
