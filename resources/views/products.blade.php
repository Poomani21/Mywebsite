@extends('admin.layout.app')

@section('content')

<style>
/* Product Card */
.product-card {
    border-radius: 12px;
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
    background: #fff;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}
.product-img-wrap {
    position: relative;
    background: #f8f8f8;
    padding: 10px;
}
.product-img {
    width: 100%;
    height: 220px;
    object-fit: contain;
}
.price-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff9900;
    color: #000;
    padding: 4px 10px;
    font-weight: bold;
    border-radius: 20px;
    font-size: 14px;
}
.add-to-cart-btn { font-weight: 600; }

/* Popup Modal */
.cart-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    overflow: auto;
}
.cart-modal-content {
    background: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 12px;
    max-width: 450px;
    text-align: center;
    position: relative;
}
.cart-modal-close {
    position: absolute;
    top: 10px; right: 15px;
    font-size: 20px;
    cursor: pointer;
}
.cart-modal-content img {
    width: 120px; height: 120px;
    object-fit: contain; margin-bottom: 15px;
}
.cart-modal-content h5 { margin-bottom: 10px; font-weight: 600; }
.cart-modal-content p { color: #555; margin-bottom: 10px; font-size: 16px; }
.cart-modal-content .quantity-wrapper {
    display: flex; justify-content: center; align-items: center;
    margin-bottom: 15px;
}
.cart-modal-content .quantity-wrapper button {
    border-radius: 50%; border: 1px solid #ccc; background: #f0f0f0;
    width: 32px; height: 32px; font-size: 18px;
}
.cart-modal-content .quantity-wrapper input {
    width: 50px; text-align: center; border: 1px solid #ccc; margin: 0 5px;
    border-radius: 5px; padding: 5px;
}
.cart-modal-content .btn {
    border-radius: 30px;
    min-width: 120px;
    margin: 5px;
}
</style>

<section>
<div class="container my-5">
  <header class="mb-4">
    <h3>New products</h3>
  </header>

  <div class="row">
    @foreach ($products as $product)
    <div class="col-lg-3 col-md-6 col-sm-6 d-flex mb-4">
      <div class="card product-card w-100 shadow-sm">
        <div class="product-img-wrap">
          <img src="{{ asset('images/' . $product->image) }}" class="card-img-top product-img" />
          <span class="price-badge">₹{{ $product->price }}</span>
        </div>

        <div class="card-body d-flex flex-column">
          <h6 class="card-title text-truncate">{{ $product->name }}</h6>
          <p class="card-text small text-muted">{{ Str::limit($product->description, 60) }}</p>

          <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form" data-product-id="{{ $product->id }}">
            @csrf
            <input type="hidden" value="{{ $product->id }}" name="id">
            <input type="hidden" value="{{ $product->name }}" name="name">
            <input type="hidden" value="{{ $product->price }}" name="price">
            <input type="hidden" value="{{ $product->image }}" name="image">
            <input type="hidden" value="1" name="quantity">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 add-to-cart-btn">
                    <i class="fas fa-shopping-cart"></i> Add to Cart 
                </button>
                
                <!-- Cart count badge button -->
                <button type="button"
                        class="btn btn-outline-secondary position-relative product-cart-count-btn"
                        data-product-id="{{ $product->id }}"
                        data-qty="{{ $cartItems->has($product->id) ? $cartItems[$product->id]->quantity : 0 }}">
                  🛒 Cart
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger product-cart-count">
                      {{ $cartItems->has($product->id) ? $cartItems[$product->id]->quantity : 0 }}
                  </span>
                </button>

        
                                            

            </div>
        </form>
        
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
</section>

<!-- Cart Modal -->
<div class="cart-modal" id="cartModal">
  <div class="cart-modal-content">
    <span class="cart-modal-close">&times;</span>
    <img id="modalProductImage" src="" alt="Product">
    <h5 id="modalProductName"></h5>
    <p>Price: <span id="modalProductPrice"></span></p>

    <div class="quantity-wrapper">
      <button id="decreaseQty">-</button>
      <input type="number" id="modalQuantity" value="1" min="1">
      <button id="increaseQty">+</button>
    </div>

    <p>Total: ₹<span id="modalTotalPrice"></span></p>

    <div>
      <button class="btn btn-success" id="goToCart">Go to Cart</button>
      <button class="btn btn-secondary" id="continueShopping">Continue Shopping</button>
    </div>
  </div>
</div>

@endsection

<script>
  
  
  document.addEventListener('DOMContentLoaded', function () {

const cartModal = document.getElementById('cartModal');
const modalClose = cartModal.querySelector('.cart-modal-close');
const modalProductName = document.getElementById('modalProductName');
const modalProductImage = document.getElementById('modalProductImage');
const modalProductPrice = document.getElementById('modalProductPrice');
const modalQuantity = document.getElementById('modalQuantity');
const modalTotalPrice = document.getElementById('modalTotalPrice');
const goToCartBtn = document.getElementById('goToCart');
const continueShoppingBtn = document.getElementById('continueShopping');

// Store product quantities
let cartProducts = {}; // { productId: quantity }

// Add to Cart
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const productId = formData.get('id');
        const productName = formData.get('name');
        const productImage = formData.get('image');
        const productPrice = parseFloat(formData.get('price'));

        // Find the badge element in this card
        const badgeEl = this.querySelector('.product-cart-count');

        fetch(this.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': formData.get('_token') },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                // Update cartProducts mapping
                cartProducts[productId] = data.productQuantity || 1;

                // Update this card badge
                badgeEl.innerText = cartProducts[productId];

                // also update button data-qty
                const cartBtn = this.querySelector('.product-cart-count-btn');
                if (cartBtn) {
                    cartBtn.setAttribute('data-qty', cartProducts[productId]);
                }

                // Show modal
                modalProductName.innerText = productName;
                modalProductImage.src = "{{ asset('images') }}/" + productImage;
                modalProductPrice.innerText = productPrice.toFixed(2);
                modalQuantity.value = cartProducts[productId];
                modalTotalPrice.innerText = (cartProducts[productId] * productPrice).toFixed(2);
                cartModal.style.display = 'block';
            }
        })
        .catch(err => console.error(err));
    });
});

// Close modal
modalClose.addEventListener('click', () => cartModal.style.display = 'none');
continueShoppingBtn.addEventListener('click', () => cartModal.style.display = 'none');

// Quantity buttons in modal
function updateModalQuantity(increment) {
    let qty = parseInt(modalQuantity.value) + increment;
    if(qty < 1) qty = 1;
    modalQuantity.value = qty;

    const productId = Object.keys(cartProducts)[Object.keys(cartProducts).length - 1];
    const productPrice = parseFloat(modalProductPrice.innerText);

    modalTotalPrice.innerText = (qty * productPrice).toFixed(2);

    // Update cartProducts mapping
    cartProducts[productId] = qty;

    // Update badge on the card
    const badgeEl = document.querySelector(`.add-to-cart-form[data-product-id="${productId}"] .product-cart-count`);

    if (badgeEl) {
    badgeEl.innerText = qty;

    const cartBtn = badgeEl.closest('.product-card').querySelector('.product-cart-count-btn');
    if (cartBtn) {
        cartBtn.setAttribute('data-qty', qty);
    }
}


    // Update server
    updateCartQuantity(productId, qty);
}

document.getElementById('increaseQty').addEventListener('click', () => updateModalQuantity(1));
document.getElementById('decreaseQty').addEventListener('click', () => updateModalQuantity(-1));

// Go to cart button
goToCartBtn.addEventListener('click', () => window.location.href = "{{ route('cart.list') }}");

function updateCartQuantity(id, quantity){
    fetch("{{ route('cart.update') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ id, quantity })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            // Nothing extra needed here, badge updated already per product
        }
    });
}

});

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.product-cart-count-btn');
    if (!btn) return;

    const qty = parseInt(btn.getAttribute('data-qty')) || 0;

    if (qty > 0) {
        window.location.href = "{{ route('cart.list') }}";
    } 
});



</script>
  