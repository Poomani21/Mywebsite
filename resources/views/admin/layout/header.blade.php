
  <!-- Jumbotron -->
  <div class="p-3 text-center bg-white border-bottom">
    <div class="container">
      <div class="row gy-3">
        <!-- Left elements -->
        <div class="col-lg-2 col-sm-4 col-4">
          <a href="{{route('products.list')}}" target="_blank" class="float-start">
            <img src="http://localhost/mywebsite/public/images/mywebsiteimage.jpg" height="60" class="rounded-circle"/>
          </a>
        </div>
        <!-- Left elements -->

        <!-- Center elements -->
        <div class="order-lg-last col-lg-5 col-sm-8 col-8">
          <div class="d-flex float-end">

                @guest

            <a href="{{ route('login') }}" class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center"> <i class="fas fa-user-alt m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Login</p> </a>
            <a href="{{ route('register') }}" class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center" > <i class="fas fa-user-alt m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Register</p> </a>

                @else
                <a href="{{ route('logout') }}" class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center"> <i class="fas fa-user-alt m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Logout</p> </a>
                @endguest
                
            <a href="{{ route('products.list')}}" class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center"> <i class="fas fa-heart m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Wishlist</p> </a>
            <a href="{{ route('cart.list') }}" class="border rounded py-1 px-3 nav-link d-flex align-items-center" > <i class="fas fa-shopping-cart m-1 me-md-2"></i><p class="d-none d-md-block mb-0">My cart {{ Cart::getTotalQuantity()}} </p> </a>
            <a href="{{route('product.create')}}" class="border rounded py-1 px-3 nav-link d-flex align-items-center" > <i class="fas fa-shopping-cart m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Add Product </p> </a>

          </div>
        </div>
        <!-- Center elements -->

        <!-- Right elements -->
        <div class="col-lg-5 col-md-12 col-12">
          <div class="input-group float-center">
            <div class="form-outline">
              <input type="search" id="form1" class="form-control" placeholder="Search" style="padding: 0.375rem 3.75rem;" />
    
            </div>
            <button type="button" class="btn btn-primary shadow-0" style="padding: 20px;
    height: 7px;">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
        <!-- Right elements -->
      </div>
    </div>
  </div>
  <!-- Jumbotron -->

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <!-- Container wrapper -->
    <div class="container justify-content-center justify-content-md-between">
      <!-- Toggle button -->
      <button
              class="navbar-toggler border py-2 text-dark"
              type="button"
              data-mdb-toggle="collapse"
              data-mdb-target="#navbarLeftAlignExample"
              aria-controls="navbarLeftAlignExample"
              aria-expanded="false"
              aria-label="Toggle navigation"
              >
        <i class="fas fa-bars"></i>
      </button>


    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
  <!-- Jumbotron -->
  
  <!-- Jumbotron -->
