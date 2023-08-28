@extends('admin.layout.app')

@section('content')

<style>
   .image{
    height: 168px;
   }
   
</style>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Product Image</th>
      <th scope="col">Price</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($products as $key => $product)
    <tr>
      <th scope="row">{{++$key}}</th>
      <td>{{$product->name}}</td>
      <td><img  src="{{'http://localhost/mywebsite/storage/app/image/'.$product->image}}" class="image" /></td>

      <td>{{$product->price}}</td>
      <td>

      </td>
    </tr>
    @empty
    <tr>
        <td> no product found !</td>
    </tr>
    @endforelse
  </tbody>
</table>

@endsection