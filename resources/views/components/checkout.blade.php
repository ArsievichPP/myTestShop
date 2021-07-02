@isset($products)
    <div class="container borders border-top">
        <form class="row g-3" method="post" action="{{route('order')}}">
            @csrf

            <div class="col-md-4">
                <label for="inputName" class="form-label">Имя</label>
                <input type="text" class="form-control" id="inputName" name="name">
            </div>
            <div class="col-md-4">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="email">
            </div>
            <div class="col-md-4">
                <label for="inputPhone" class="form-label">Моб. телефон</label>
                <input type="text" class="form-control" id="inputPhone" name="phone">
            </div>
            <div class="col-6">
                <label for="inputAddress" class="form-label">Адрес</label>
                <input type="text" class="form-control" id="inputAddress" name="address"
                       placeholder="Київ, вул. Хрещатик, буд. 11, кв. 3,  01220">
            </div>
            <div class="col-md-4">
                <label for="inputDelivery" class="form-label">Доставка</label>
                <select id="inputDelivery" class="form-select" name="delivery">
                    @foreach($deliveryMethods as $method)
                        <option value="{{$method->id}}">{{$method->method}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Заказать</button>
            </div>
        </form>
    </div>
@endisset
