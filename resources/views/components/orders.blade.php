<div class="container border-top borders">
    <h4>Ваши заказы:</h4>
    <div class="accordion" id="accordionExample">
        @foreach($orders as $order)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{$order->id}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{$order->id}}" aria-expanded="true"
                            aria-controls="collapse{{$order->id}}">
                        Заказ #{{$order->id}} {{$order->status}}
                    </button>
                </h2>
                <div id="collapse{{$order->id}}" class="accordion-collapse collapse hidden" aria-labelledby="headingOne"
                     data-bs-parent="#accordionExample">
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
                    @if($order->status === 'Payment accepted' or
                        $order->status ==='Processing in progress'or
                        $order->status === 'Ready for delivery')
                        <div class="container row justify-content-end">
                            <a href="{{route('refund', [$order->id])}}" class="btn btn-warning btn col-2 mb-4"
                               role="button"><strong>Refund {{$order->total_price}}$</strong></a>
                        </div>
                    @elseif($order->status === 'Awaiting payment')
                        <div class="container row justify-content-end">
                            <a href="{{route('payment.show', [$order->id])}}" class="btn btn-success btn col-2 mb-4"
                               role="button"><strong>Pay {{$order->total_price}}$</strong></a>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
</div>
