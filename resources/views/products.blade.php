@extends('admin.layout.app')

@section('content')

<!-- Products -->
<section>
  <div class="container my-5">
    <header class="mb-4">
      <h3>New products</h3>
    </header>

    <div class="row">

    @foreach ($products as $product)
      <div class="col-lg-3 col-md-6 col-sm-6 d-flex">
        <div class="card w-100 my-2 shadow-2-strong">
          <img src="{{'http://localhost/mywebsite/storage/app/image/'.$product->image}}" class="card-img-top" style="aspect-ratio: 1 / 1" />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">${{ $product->price }}</p>
            <p class="card-text">{{ $product->description }}</p>
            <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="id">
                        <input type="hidden" value="{{ $product->name }}" name="name">
                        <input type="hidden" value="{{ $product->price }}" name="price">
                        <input type="hidden" value="{{ $product->image }}"  name="image">
                        <input type="hidden" value="1" name="quantity">
                       
                    
            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
              <button  class="btn btn-primary shadow-0 me-1">Add to cart</button>
              <a href="#!" class="btn btn-light border px-2 pt-2 icon-hover"><i class="fas fa-heart fa-lg text-secondary px-1"></i></a>
            </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
<!-- Products -->
