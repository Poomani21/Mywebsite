<style>
  /* Header container */
.shop-header {
    position: sticky;
    top: 0;
    z-index: 999;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* Action icons right side */
.header-actions a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-left: 10px;
    padding: 8px 12px;
    border-radius: 20px;
    background: #f5f5f5;
    color: #000;
    text-decoration: none;
    transition: all 0.2s ease;
}

.header-actions a:hover {
    background: #ff9900;
    color: #000;
}

/* Cart badge */
.cart-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: red;
    color: #fff;
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 50%;
}

/* Bottom navbar */
.main-nav {
    background: #232f3e;
}

.main-nav .nav-link {
    color: #fff !important;
    font-weight: 500;
    padding: 10px 16px;
}

.main-nav .nav-link:hover {
    background: #37475a;
    border-radius: 4px;
}

/* User avatar circle */
.user-avatar {
    width: 36px;
    height: 36px;
    background-color: #ff9900; /* Amazon-style */
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: all 0.2s ease-in-out;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.user-avatar:hover {
    transform: scale(1.1);
}

/* Dropdown menu */
.user-dropdown-menu {
    min-width: 180px;
    border-radius: 8px;
    padding: 0.5rem 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border: none;
    background-color: #fff;
    margin-top: 8px;
}

/* Dropdown items */
.user-dropdown-menu .dropdown-item {
    padding: 10px 20px;
    color: #333;
    font-weight: 500;
    transition: all 0.2s ease;
}

.user-dropdown-menu .dropdown-item:hover {
    background-color: #f5f5f5;
    color: #ff9900; /* Amazon accent on hover */
}

/* Logout button highlight */
.user-dropdown-menu .logout-btn:hover {
    background-color: #ffebcc;
    color: #d98200;
    font-weight: 600;
}

/* Divider styling */
.user-dropdown-menu .dropdown-divider {
    margin: 0.5rem 0;
    border-top: 1px solid #eee;
}

.guest-link {
    color: #111;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
}

.guest-link:hover {
    background-color: #f0f2f5;
    color: #000;
    text-decoration: none;
}

.register-btn:hover {
    background-color: #e9ecef;
}



/* ===== MOBILE AVATAR DROPDOWN FIX (STABLE NAVBAR) ===== */
@media (max-width: 991px) {

/* keep navbar normal */
.navbar-collapse {
    overflow: visible !important;
}

/* dropdown parent */
.nav-item.dropdown {
    position: relative;
}

/* dropdown menu */
.user-dropdown-menu {
    position: absolute !important;
    right: 10px;
    top: calc(100% + 10px);
    min-width: 200px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.18);
    z-index: 1050;
}

}

/* SHOW TOGGLER ON MOBILE */
@media (max-width: 991px) {
  .navbar-toggler {
      display: block !important;
  }
}
@media (max-width: 576px) {
    .user-avatar {
        width: 34px;
        height: 34px;
        font-size: 12px;
    }
}


</style>


<nav class="navbar navbar-expand-lg main-nav">
  <div class="container">
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <i class="fas fa-bars"><svg width="26" height="26" viewBox="0 0 24 24" fill="none"
        xmlns="http://www.w3.org/2000/svg">
       <path d="M3 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
       <path d="M3 12H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
       <path d="M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
   </svg></i>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('products.list') }}">Home</a>
        </li>

        @if(auth()->check() && auth()->user()->role === 'Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('product.index') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('product.create') }}">Add Product</a>
            </li>
        @endif

        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.list') }}">My Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('orders.index') }}">
            @if(auth()->check() && auth()->user()->role === 'Admin')
                User Orders List
              @else
                My Orders List
            @endif
          </a>
        </li>        
      </ul>

      <!-- User Avatar on top-right corner -->
      <!-- User Avatar on top-right corner -->
      @auth
      <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="user-avatar">

                    @php
                        $user = auth()->user();
                        $name = $user->name ?? '';
                        $parts = explode(' ', $name);
                        $initials = strtoupper(
                            substr($parts[0],0,1) .
                            (isset($parts[1]) ? substr($parts[1],0,1) : '')
                        );
                    @endphp

                     @if($user->image && file_exists(public_path('images/'.$user->image)))
                     <img src="{{ asset('images/'.$user->image) }}"
                              alt="avatar">
                      @else
                          {{ $initials }}
                      @endif

                  </div>
                  <span class="ms-2 d-none d-md-inline">{{ auth()->user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userDropdown">

                <li>
                  <a class="dropdown-item" href="{{ route('account.info') }}">
                
                  My Account Info
                  
                 </a>
                </li>

                  
                  <li><hr class="dropdown-divider"></li>
                  <li>
                      <a class="dropdown-item logout-btn" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </li>
              </ul>
          </li>
      </ul>
      @endauth

      @guest
        <ul class="navbar-nav ms-auto">

            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link d-flex align-items-center guest-link">
                    <i class="fas fa-user me-1"></i>
                    <span>Login</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link d-flex align-items-center guest-link register-btn">
                    <i class="fas fa-user-plus me-1"></i>
                    <span>Register</span>
                </a>
            </li>

        </ul>
      @endguest



    </div>
  </div>
</nav>



{{-- @guest
              <a href="{{ route('login') }}" class="text-dark">
                <i class="fas fa-user"></i> <span class="d-none d-md-inline">Login</span>
              </a>
              <a href="{{ route('register') }}" class="text-dark">
                <i class="fas fa-user-plus"></i> <span class="d-none d-md-inline">Register</span>
              </a>
            @else
              <a href="{{ route('logout') }}" class="text-dark">
                <i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">Logout</span>
              </a>
            @endguest --}}
