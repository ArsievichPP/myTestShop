    <nav class="container" >
    <a href="{{route('main')}}" class="logo"><h1>Test-Shop.ua</h1> </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="log-out" type="submit">Выйти из аккаунта</button>
        </form>

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
        </ul>
</nav>
