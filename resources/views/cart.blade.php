
@extends('admin.layout.app')

@section('content')
<style>
.gradient-custom {
/* fallback for old browsers */
background: #6a11cb;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
}

</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">



<section class="h-100 gradient-custom">
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Cart - {{ Cart::getTotalQuantity() }} items</h5>
          </div>
          <div class="card-body">

            @foreach ($cartItems as $item)
            <!-- Single item -->
            <div class="row">
              <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                <!-- Image -->
                <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                  <img src="{{'http://localhost/mywebsite/storage/app/image/'.$item->attributes->image}}"
                    class="w-100" alt="Blue Jeans Jacket" />
                  <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                  </a>
                </div>
                <!-- Image -->
              </div>

              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                <!-- Data -->
                <p><strong>{{ $item->name }}</strong></p>
                <p>Color: blue</p>
                <p>Size: M</p>
               
                <form action="{{ route('cart.remove') }}" method="POST">
                  @csrf
                  <input type="hidden" value="{{ $item->id }}" name="id">
                  <button type="button" class="btn btn-primary btn-sm me-1 mb-2" data-mdb-toggle="tooltip"
                  title="Move to the wish list">Wish list
                  <i class="fas fa-trash"></i>
                </button>
                <button type="submit" class="btn btn-danger btn-sm mb-2" data-mdb-toggle="tooltip"
                  title="Remove item">
                  <i class="fas fa-heart">Remove</i>
                </button>
               </form>

              
                <!-- Data -->
              </div>

              <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <!-- Quantity -->
                <div class="d-flex mb-4" style="max-width: 300px">
                  <button class="btn btn-primary px-3 me-2" style="height: 39px;"
                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                    <i class="fas fa-minus"></i>
                  </button>

          

                  <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                  <div class="form-outline">
                   
                    <input type="hidden" name="id" value="{{ $item->id}}" >
                    <input id="form1" min="0" name="quantity" value="{{ $item->quantity }}" type="number" class="form-control" />
                    <!-- <label class="form-label" for="form1">Quantity</label> -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                  </div>

                  <button class="btn btn-primary px-3 ms-2" style="height: 39px"
                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- Quantity -->

                <!-- Price -->
              
                <p class="text-start text-md-center">
                  <strong>${{$item->price}}</strong>
                </p>
                
                <!-- Price -->
              </div>
            </div>
            @endforeach
            <br>
            <!-- Single item -->
            <form action="{{ route('cart.clear') }}" method="POST">
              @csrf
              <button class="btn btn-danger">Remove All Cart</button>                            
            </form>
           

          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <p><strong>Expected shipping delivery</strong></p>
            <p class="mb-0">12.10.2020 - 14.10.2020</p>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body">
            <p><strong>We accept</strong></p>
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
              alt="Visa" />
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
              alt="American Express" />
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
              alt="Mastercard" />
            <img class="me-2" width="45px"
              src="https://mdbcdn.b-cdn.net/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.webp"
              alt="PayPal acceptance mark" />
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Summary</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Products
                <span>${{ Cart::getTotal() }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Quantity
                <span>{{ Cart::getTotalQuantity()}}</span>
              </li>
              <li
                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>Total amount</strong>
                  <strong>
                    <p class="mb-0">(including VAT)</p>
                  </strong>
                </div>
                <span><strong>${{ Cart::getTotal() }}</strong></span>
              </li>
            </ul>

            @php 
            $total_amount_price=Cart::getTotal();
            @endphp
            <input type="hidden"  name="total_amount_price" value="{{$total_amount_price}}">
           
            
            <a href="{{route('make.payment',$total_amount_price)}}" class="btn btn-primary btn-lg btn-block">
              Go to checkout via Paypal
</a>

<a href="{{route('address.add')}}" class="btn btn-secondary btn-lg btn-block">
            Address
</a>
         
           

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection