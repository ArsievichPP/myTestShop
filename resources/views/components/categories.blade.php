<div class="container">
    <h4>Categories</h4>
    <div class="row">
        @foreach($categories as $category)
            <div class="card categories">
                <img src="/images/{{$category->image}}"  height="100px" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$category->name}}</h5>
                    <ul>
                        @foreach($category->subcategories as $subcategory)
                            <li><a href="{{route('category', $subcategory->id)}}">{{$subcategory->name}}</a></li>
                        @endforeach
                    </ul>
                    <a href="{{route('category', $category->id)}}" class="btn btn-primary">В категорию!</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
