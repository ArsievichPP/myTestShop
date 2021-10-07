    <nav class="container" >
    <a href="{{route('main')}}" class="logo"><h1>Test-Shop.ua</h1> </a>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{route('main')}}">Все товары</a>
            </li>
            <li class="nav-ite m">
                <a class="nav-link" href="{{route('categories')}}">Категории</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('cart')}}">Корзина</a>
            </li>
            <li>
                <div class="dropdown">
                    <button class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        {{\Illuminate\Support\Facades\Auth::user()->name}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{route('user')}}">Мои данные</a></li>
                        <li><a class="dropdown-item" href="{{route('orders')}}">Мои заказы</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="log-out btn dropdown-item" type="submit">Выйти из аккаунта</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
</nav>
