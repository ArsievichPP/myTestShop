<div class="container">
    <h2>{{$product->name}}</h2>
    <div class="row">
        <div class="col">
            <img
                src="/images/{{$product->image}}"
                height="350px">
        </div>
        <div class="col">
            <h3>{{$product->price}}$</h3>
            <form method="post" action="{{route('addToCart')}}">
                @csrf
                <label>
                    Осталось на складе: {{$product->quantity}}<br>
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <input class="input-group" type="number" name="quantity" value="1" min="1" max="{{$product->quantity}}" required>
                    <button class="btn btn-success" type="submit">Добавить в корзину</button>
                </label>

                <script>

                </script>
            </form>
        </div>
    </div>
    <h5>Описание</h5>
    <p> {{$product->description}}</p>
</div>
