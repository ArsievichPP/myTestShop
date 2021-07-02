<div class="container borders">
    <div class="row">
        @foreach($products as $product)
            <div class="col">
                <div class="card product">
                    <img src="/images/{{$product->image}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <h5> {{$product->price}}$</h5>
                        <a href="{{route('product', ['id'=> $product->id])}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="paginate">
        @php
            echo $products->links();
        @endphp
    </div>
</div>

