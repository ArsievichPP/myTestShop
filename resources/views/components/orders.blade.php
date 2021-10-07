<div class="container border-top borders">
    <h4>Ваши заказы:</h4>
    <div class="accordion" id="accordionExample">
        @foreach($orders as $order)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{$order->id}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                    Заказ #{{$order->id}} {{$order->status}}
                </button>
            </h2>
            <div id="collapse{{$order->id}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                @foreach($order->ShoppingLists as $list)
                <div class="accordion-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>{{$list->product->name}}</th>
                            <td><img src="/images/{{$list->product->image}}" width="50px"></td>
                            <td>{{$list->product->price}}$</td>
                            <td>{{$list->quantity}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
                    <h5>К оплате {{$order->total_price}}$</h5>
            </div>
        </div>
        @endforeach
    </div>
</div>
