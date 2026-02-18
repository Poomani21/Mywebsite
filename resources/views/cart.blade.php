@extends('admin.layout.app')

@section('content')
<style>
/* Gradient background */
.gradient-custom {
  background: #f5f5f5;
  min-height: 100vh;
  padding-bottom: 50px;
}

/* Card styles */
.card {
  border-radius: 12px;
  box-shadow: 0 4px 18px rgba(0,0,0,0.08);
  border: none;
  margin-bottom: 20px;
}

/* Card Header */
.card-header {
  background-color: #fff;
  border-bottom: 1px solid #eee;
  font-weight: 600;
  font-size: 18px;
}

/* Cart Item Row */
.cart-item-row {
  border-bottom: 1px solid #eee;
  padding: 20px 0;
  transition: background 0.2s ease;
}
.cart-item-row:hover {
  background: #fafafa;
}

/* Product Image */
.cart-item-image {
  width: 100%;
  height: 150px;
  object-fit: contain;
  border-radius: 8px;
  transition: transform 0.3s ease;
}
.cart-item-row:hover .cart-item-image {
  transform: scale(1.05);
}

/* Product Details */
.cart-item-details p {
  margin: 5px 0;
  font-size: 14px;
  color: #333;
}
.cart-item-details .product-name {
  font-weight: 600;
  font-size: 16px;
}

/* Quantity Controls */
.quantity-wrapper {
  display: flex;
  align-items: center;
  gap: 8px;
}
.quantity-wrapper button {
  border: 1px solid #ccc;
  background: #fff;
  width: 35px;
  height: 35px;
  font-size: 18px;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.2s ease;
}
.quantity-wrapper button:hover {
  background: #f0f0f0;
}
.quantity-wrapper input {
  width: 60px;
  text-align: center;
  border-radius: 6px;
  border: 1px solid #ccc;
  padding: 4px;
  font-size: 14px;
}

/* Buttons */
.btn {
  border-radius: 30px;
  font-weight: 500;
  transition: all 0.2s ease;
}
.btn:hover {
  opacity: 0.9;
}

/* Remove/Wishlist Buttons */
.cart-item-details .btn {
  min-width: 100px;
  font-size: 13px;
  padding: 4px 10px;
  margin-top: 5px;
}

/* Cart Summary */
.summary-card {
  position: sticky;
  top: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 18px rgba(0,0,0,0.08);
}
.summary-card ul li {
  font-size: 16px;
  padding: 10px 0;
}
.summary-card ul li span {
  font-weight: 600;
  color: #ff9900;
}

/* Checkout Buttons */
.summary-card a.btn {
  border-radius: 30px;
  font-weight: 600;
  padding: 10px 15px;
  font-size: 16px;
  transition: all 0.2s ease;
}
.summary-card a.btn-primary:hover {
  background-color: #e68a00;
  border-color: #e68a00;
}
.summary-card a.btn-secondary:hover {
  background-color: #555;
  border-color: #555;
}

/* Payment Logos */
.payment-logos img {
  margin-right: 10px;
  height: 40px;
  filter: grayscale(0.1);
  transition: all 0.2s ease;
}
.payment-logos img:hover {
  filter: grayscale(0);
}

/* Responsive adjustments */
@media (max-width: 768px){
  .cart-item-row {
    flex-direction: column;
    text-align: center;
  }
  .cart-item-details, .cart-item-quantity, .cart-item-price {
    margin-top: 10px;
  }
  .summary-card {
    margin-top: 20px;
  }
}

.text-danger {
    color: #dc3545 !important;
    font-weight: 600;
}

.text-green {
    color: #258c34 !important;
    font-weight: 600;
}

a.disabled {
    pointer-events: none;
    opacity: 0.6;
    cursor: not-allowed;
}
#toast-container {
    z-index: 999999 !important;
    pointer-events: auto;
}


</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

<script>
  const stripe = Stripe("{{ config('services.stripe.key') }}");
</script>

<section class="gradient-custom">
  <div class="container">
    <div class="row justify-content-center">
      
     <!-- Payment Status Messages -->
    <div id="payment-loading" class="alert alert-info d-none">
      Processing your payment... Please wait ⏳
    </div>

    <div id="payment-success" class="alert alert-success d-none">
      Payment successful! Your order is being created...
    </div>

    <div id="payment-error" class="alert alert-danger d-none">
       Payment failed. <span id="payment-error-message"></span>
    </div>

    <div id="selectAddress-error" class="alert alert-danger d-none">
      Please select the delivery address.
   </div>

   <div  id="choose-error" class="alert alert-danger d-none">
    Please add and select the address then click checkout
  </div>

    @if(session('error'))
        <div  id="flash-error" class="alert alert-danger">
             {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div  id="flash-success" class="alert alert-success">
             {{ session('success') }}
        </div>
    @endif


      <!-- Cart Items Column -->
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-header">
            Cart - {{ Cart::getTotalQuantity() }} items
          </div>
          <div class="card-body">

            @foreach ($cartItems as $item)
            <div class="row cart-item-row align-items-center">
              <!-- Image -->
              <div class="col-lg-3 col-md-4 text-center">
                <img src="{{ asset('images/' . $item->attributes->image) }}" class="cart-item-image" alt="{{ $item->name }}">
              </div>

              <!-- Details -->
              <div class="col-lg-5 col-md-5 cart-item-details">
                <p class="product-name">{{ $item->name }}</p>
                <p>Color: Blue</p>
                <p>Size: M</p>
                <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                  @csrf
                  <input type="hidden" value="{{ $item->id }}" name="id">
                  <button type="submit" class="btn btn-danger btn-sm mt-2"><i class="fas fa-trash"></i> Remove</button>
                </form>
                <a href="{{ route('products.list') }}" class="btn btn-outline-secondary btn-sm mt-2">
                    <i class="fas fa-heart"></i> Go Back
                </a>
              
              </div>

              <!-- Quantity & Price -->
              <div class="col-lg-4 col-md-3 cart-item-quantity text-center">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <div class="quantity-wrapper">
                        <button type="button" class="qty-btn" data-action="decrease" data-id="{{ $item->id }}">-</button>
            
                        <input type="number"
                               class="qty-input"
                               value="{{ $item->quantity }}"
                               min="1"
                               readonly>
            
                        <button type="button" class="qty-btn" data-action="increase" data-id="{{ $item->id }}">+</button>
                    </div>
                </div>
            
                <p class="fw-bold">${{ $item->price }}</p>
            </div>
            
            </div>
            @endforeach

            <form action="{{ route('cart.clear') }}" method="POST" class="mt-3">
              @csrf
              <button class="btn btn-danger w-100">Remove All Cart</button>
            </form>

          </div>
        </div>

        <div class="card mb-4">
          <div class="card-body">
            <p class="mb-1"><strong>Deliver to</strong></p>
        
            <select id="addressSelect" class="form-select">
              <option value="" selected disabled>-- Select Address --</option>
              @foreach($addresses as $address)
                <option value="{{ $address->id }}">
                  {{ $address->address_line1 }}, {{ $address->city }}
                </option>
              @endforeach
            </select>
        
            <button class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#addressModal">
              + Add New Address
            </button>
          </div>
        </div>
        

        <!-- Shipping Info -->
        <div class="card mb-4">
          <div class="card-body">
            <p><strong>Expected shipping delivery</strong></p>
        
            <p id="deliveryEstimate" class="mb-1 text-muted">
              Select an address to see delivery date
            </p>
        
            <p id="deliveryAddress" class="mb-0 small text-secondary"></p>
          </div>
        </div>
        
        
        
        

        <!-- Payment Logos -->
        <div class="card mb-4">
          <div class="card-body payment-logos d-flex flex-wrap align-items-center">
            <p class="me-2 mb-0">We accept:</p>
        
            <!-- Visa -->
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="28" viewBox="0 0 36 24">
              <path fill="#1a1f71" d="M0 0h36v24H0z"/>
              <text x="2" y="17" fill="#fff" font-size="14" font-family="Arial, sans-serif">VISA</text>
            </svg>
        
            <!-- American Express -->
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="28" viewBox="0 0 36 24">
              <rect width="36" height="24" fill="#2e77bc"/>
              <text x="3" y="17" fill="#fff" font-size="10" font-family="Arial, sans-serif">AMEX</text>
            </svg>
        
            <!-- Mastercard -->
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="28" viewBox="0 0 36 24">
              <circle cx="14" cy="12" r="9" fill="#eb001b"/>
              <circle cx="22" cy="12" r="9" fill="#f79e1b"/>
            </svg>
        
            <!-- PayPal -->
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="28" viewBox="0 0 36 24">
              <rect width="36" height="24" fill="#003087"/>
              <text x="4" y="17" fill="#fff" font-size="10" font-family="Arial, sans-serif">PayPal</text>
            </svg>
        
          </div>
        </div>
        
      </div>

      <!-- Summary Column -->
      <div class="col-lg-4">
        <div class="card summary-card mb-4">
          <div class="card-header">
            Cart - <span id="cartTotalQty">{{ Cart::getTotalQuantity() }}</span> items
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item d-flex justify-content-between px-0">
                Products
                <span>$<span id="summaryTotalPrice">{{ Cart::getTotal() }}</span></span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-0">
                Quantity
                <span id="summaryTotalQty">{{ Cart::getTotalQuantity() }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-0">
                <strong>Total amount</strong>
                <span><strong>$<span id="summaryGrandTotal">{{ Cart::getTotal() }}</span></strong></span>
              </li>
            </ul>

            <a href="{{ route('make.payment', Cart::getTotal()) }}" 
              id="checkoutBtn"
              data-base-url="{{route('make.payment', Cart::getTotal())}}"
              class="btn btn-primary w-100 mb-2 disabled"
              aria-disabled="true"
              >
              Go to Checkout via Paypal
            </a>

            <form action="#" method="POST" id="card-payment-form">
              @csrf
          
              <input type="hidden" name="stripeToken" id="stripeToken">
              <input type="hidden" name="address_id" id="card_address_id" value="">
          
              <button type="button" id="payWithCardBtn" class="btn btn-success w-100 disabled" aria-disabled="true">
                  Pay with Card
              </button>
          </form>
          
          <br>

            <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#addressModal" id="addressButton">
              Add Address
            </button>
            

          </div>
        </div>
      </div>

    </div>
  </div>
  

  <div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header">
          <h5 class="modal-title">Add New Address</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <form action="{{ route('address.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Address Line</label>
              <input type="text" name="address_line1" class="form-control" required>
            </div>
  
            <div class="mb-3">
              <label class="form-label">City</label>
              <input type="text" name="city" class="form-control" required>
            </div>
  
            <div class="mb-3">
              <label class="form-label">State</label>
              <input type="text" name="state" class="form-control" required>
            </div>
  
            <div class="mb-3">
              <label class="form-label">Pincode</label>
              <input type="text" name="pincode" class="form-control" required>
            </div>
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Address</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Card Payment Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enter Card Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="card-element" class="form-control"></div>
        <div id="card-errors" class="text-danger mt-2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmCardPayment" class="btn btn-primary">
          Pay Now
        </button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="removeConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Remove item?</h5>
        
        <button type="button" class="btn-close" id="removeModalClose" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        
          <p>Are you sure you want to remove this item from your cart?</p>
        
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" id="cancelRemoveBtn">Cancel</button>
        <button class="btn btn-danger" id="confirmRemoveBtn">Yes, Remove</button>
      </div>
    </div>
  </div>
</div>

</section>

<script>

$(document).ready(function () {
      setTimeout(function () {
          $('#flash-success').fadeOut('slow');
          $('#flash-error').fadeOut('slow');
      }, 5000); // 5 seconds
  });


  document.getElementById('addressSelect')?.addEventListener('change', function () {
      const addressId = this.value;
  
      if (!addressId) {
          document.getElementById('deliveryEstimate').innerText = 'Select an address to see delivery date';
          document.getElementById('deliveryAddress').innerText = '';
          return;
      }
  
      const url = "{{ route('cart.delivery.estimate', ':id') }}".replace(':id', addressId);
  
      const estimateEl = document.getElementById('deliveryEstimate');
      const addressEl  = document.getElementById('deliveryAddress');

      fetch(url)
          .then(res => res.json())
          .then(data => {
          
            if (data.success) {

              estimateEl.classList.add('text-green');
              estimateEl.classList.remove('text-danger');
              estimateEl.innerText = data.estimate;
              addressEl.innerText  = 'Delivering to: ' + data.address;

              const addressId = document.getElementById('addressSelect').value;

              const btn = document.getElementById('checkoutBtn');
              const baseUrl = btn.getAttribute('data-base-url');

              // Update checkout URL with address id
              btn.href = baseUrl + '?address_id=' + addressId;

              btn.classList.remove('disabled');
              btn.removeAttribute('aria-disabled');

              // ✅ Enable Card button too
              const cardBtn = document.getElementById('payWithCardBtn');
              cardBtn.classList.remove('disabled');
              cardBtn.removeAttribute('aria-disabled');

              // ✅ Set address_id for card form
              document.getElementById('card_address_id').value = addressId;

              $('#addressButton').hide();
              
            } else {

               // ❌ Show in danger (red)
               estimateEl.classList.add('text-danger');
               estimateEl.classList.remove('text-green');

                // Optional: clear address text
                addressEl.innerText = '';
                estimateEl.innerText = 'Delivery is not available for the selected address';
                $('#checkoutBtn')
                .addClass('disabled')
                .attr('aria-disabled', 'true');
                $('#payWithCardBtn').addClass('disabled').attr('aria-disabled', 'true');

                $('#addressButton').show();
               
            }

          })
          .catch(err => console.error(err));
  });
  </script>
  
  <script>

$(document).ready(function () {


function checkAddressSelected() {
    console.log("checkAddressSelected called");

    const addressValue = $('#addressSelect').val();

    if (!addressValue || addressValue == null) {

        $('#choose-error').removeClass('d-none');
        return false;
    } else {
      $('#choose-error').addClass('d-none');
        return true;
    }
}

// ✅ CALL ON PAGE LOAD
checkAddressSelected();

// ✅ HIDE TOAST WHEN ADDRESS SELECTED
$('#addressSelect').on('change', function () {
  $('#choose-error').addClass('d-none');
});

// ✅ CHECK BEFORE PAYPAL
$('#checkoutBtn').on('click', function (e) {
    if (!checkAddressSelected()) {
        e.preventDefault();
    }
});

// ✅ CHECK BEFORE CARD
$('#payWithCardBtn').on('click', function (e) {
    if (!checkAddressSelected()) {
        e.preventDefault();
    }
});

});

document.addEventListener('DOMContentLoaded', function () {

     
   
  let pendingRemoveId = null; // store which item to remove

  const removeModalEl = document.getElementById('removeConfirmModal');
  const removeModal = new bootstrap.Modal(removeModalEl);

  const confirmRemoveBtn = document.getElementById('confirmRemoveBtn');
  const cancelRemoveBtn = document.getElementById('cancelRemoveBtn');

  // Cancel button → just hide modal
  cancelRemoveBtn.addEventListener('click', function () {
      pendingRemoveId = null;
      removeModal.hide();
  });

  // Confirm remove
  confirmRemoveBtn.addEventListener('click', function () {
      if (!pendingRemoveId) return;

      fetch("{{ route('cart.remove.list') }}", {
          method: "POST",
          headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({ id: pendingRemoveId })
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              // Redirect to home (or reload cart)
              window.location.href = "{{ url('/') }}";
          } else {
              alert("Failed to remove item");
          }
      })
      .catch(err => console.error(err));

      pendingRemoveId = null;
      removeModal.hide();
  });


    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const action = this.dataset.action;
            const id = this.dataset.id;
            const input = this.parentElement.querySelector('.qty-input');
    
            let currentQty = parseInt(input.value);
            // If clicking "-" when qty is 1 → remove item
    
            if (action === 'decrease' && currentQty === 1) {
                // Open custom modal instead of confirm()
                pendingRemoveId = id;
                removeModal.show();
                console.log("removeModal",removeModal)
                return;
            }
    
            if (action === 'increase') {
                currentQty++;
            } else if (action === 'decrease' && currentQty > 1) {
                currentQty--;
            } else {
                return;
            }
    
            // Update input immediately
            input.value = currentQty;
    
            fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: id,
                    quantity: currentQty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // 🔥 Update header + summary instantly
                    document.getElementById('cartTotalQty').innerText = data.totalQuantity;
                    document.getElementById('summaryTotalQty').innerText = data.totalQuantity;
    
                    document.getElementById('summaryTotalPrice').innerText = data.totalPrice;
                    document.getElementById('summaryGrandTotal').innerText = data.totalPrice;
                    // 🔥 Update PayPal checkout link
                    const checkoutBtn = document.getElementById('checkoutBtn');
                    const baseUrl = checkoutBtn.dataset.baseUrl;
                    checkoutBtn.href = baseUrl + '/' + data.totalPrice;
                } else {
                    alert("Failed to update cart");
                }
            })
            .catch(err => console.error(err));
        });
    });

   

    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    // Open modal on button click
    document.getElementById('payWithCardBtn').addEventListener('click', function () {

      const addressValue = $('#addressSelect').val();
      console.log("addressValue",addressValue)
      
      if (!addressValue) {

        $('#selectAddress-error').removeClass('d-none');

        // Scroll to the error message smoothly
        $('html, body').animate({
            scrollTop: $('#selectAddress-error').offset().top - 20
        }, 500);
    
        setTimeout(() => {
              $('#selectAddress-error').addClass('d-none');
        }, 5000);

        return;
        
      }
        const modal = new bootstrap.Modal(document.getElementById('cardModal'));
        modal.show();
    });

    // Handle payment
    document.getElementById('confirmCardPayment').addEventListener('click', async function () {
        const payBtn = this;
        payBtn.disabled = true;
        payBtn.innerText = 'Processing...';

        // 1️⃣ Create PaymentIntent from Laravel
        const res = await fetch("{{ route('stripe.intent') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                address_id: document.getElementById('card_address_id').value
            })
        });

        const data = await res.json();

        if (data.error) {
            alert(data.error);
            payBtn.disabled = false;
            payBtn.innerText = 'Pay Now';
            return;
        }

        // 2️⃣ Confirm card payment
        const { error, paymentIntent } = await stripe.confirmCardPayment(data.clientSecret, {
            payment_method: { card: card }
        });

        if (error) {
            alert(error.message);
            payBtn.disabled = false;
            payBtn.innerText = 'Pay Now';
        } else if (paymentIntent.status === 'succeeded') {
            // 3️⃣ Redirect to success route (like PayPal)
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('stripe.success') }}";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            const pi = document.createElement('input');
            pi.type = 'hidden';
            pi.name = 'payment_intent_id';
            pi.value = paymentIntent.id;

            form.appendChild(csrf);
            form.appendChild(pi);
            document.body.appendChild(form);
            form.submit();
        }
    });




  });

  </script>
    
    
  


@endsection


