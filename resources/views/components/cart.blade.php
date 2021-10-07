<div class="container">
    @isset($products)
        <table class="table">
            <tbody>

            @foreach($products as $product)
                <tr id="product-{{$product->id}}">
                    <th scope="row">{{$loop->iteration}}</th>
                    <td><a href="{{route('product', ['id' => $product->id])}}">{{$product->name}}</td>
                    <td><img src="/images/{{$product->image}}" alt="image" width="35px"></td>
                    <td>{{$quantity[$product->id]}}</td>
                    <td>{{$product->price}}$</td>
                    <td>{{$product->price * $quantity[$product->id]}}$</td>
                    <td><button class="btn-danger btn-delete" id="deleteProduct{{$product->id}}">Удалить</button></td>
                </tr>
                <script>
                    $(document).ready(function () {
                        $("#deleteProduct{{$product->id}}").click(function () {
                            $.ajax({
                                type: "DELETE",
                                url: "/cart/{{$product->id}}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function () {
                                    let element = document.getElementById("product-{{$product->id}}");
                                    element.remove();
                                }
                            });
                        });
                    });
                </script>

            @endforeach
            </tbody>
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название товара</th>
                <th scope="col">фото</th>
                <th scope="col">Количество</th>
                <th scope="col">Цена за ед.</th>
                <th scope="col">Итого:</th>
                <th></th>
            </tr>
            </thead>
        </table>
        <h4 id="sumPrice">Сумма заказа: {{$sumPrice}}$</h4>
    @else
        <h4> Корзина пуста!!!</h4>
    @endisset


</div>
