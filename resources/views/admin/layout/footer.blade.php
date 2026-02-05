<footer class="shop-footer">
  <div class="container py-5">
    <div class="row">

      <!-- Brand -->
      <div class="col-12 col-lg-3 mb-4">
        <a href="{{ route('products.list') }}" class="footer-brand">
          <img src="{{ asset('images/mywebsiteimage.jpg') }}" height="45" alt="Logo" class="mb-2">
        </a>
        <p class="footer-text">
          Your trusted online store for quality products, fast delivery, and secure payments.
        </p>
      </div>

      <!-- About -->
      <div class="col-6 col-md-3 col-lg-2 mb-4">
        <h6 class="footer-title">About</h6>
        <ul class="footer-links">
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('contact') }}">Contact Us</a></li>
        </ul>
      </div>
      

      <!-- Help -->
      <div class="col-6 col-md-3 col-lg-2 mb-4">
        <h6 class="footer-title">Help</h6>
        <ul class="footer-links">
          <li> <a href="{{ route('help') }}">Help</a> </li>
          <li><a href="{{ route('payments') }}">Payments</a></li>
          <li><a href="{{ route('shipping') }}">Shipping</a></li>
          <li><a href="{{ route('cancellation') }}">Cancellation</a></li>
          <li><a href="{{ route('returns') }}">Returns</a></li>
        </ul>
      </div>

      <!-- Policy -->
      <div class="col-6 col-md-3 col-lg-2 mb-4">
        <h6 class="footer-title">Policy</h6>
        <ul class="footer-links">
          <li><a href="{{ route('policy.return') }}">Return Policy</a></li>
          <li><a href="{{ route('policy.terms') }}">Terms of Use</a></li>
          <li><a href="{{ route('policy.security') }}">Security</a></li>
          <li><a href="{{ route('policy.privacy') }}">Privacy</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="col-12 col-md-6 col-lg-3 mb-4">
        <h6 class="footer-title">Stay Connected</h6>
        <p class="footer-text small">Get updates on offers & new products</p>
        <div class="input-group footer-newsletter">
          <input type="email" class="form-control" placeholder="Enter your email">
          <button class="btn btn-warning" type="button">Subscribe</button>
        </div>
      </div>

    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="footer-bottom">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">

      <div class="mb-2 mb-md-0 text-center text-md-start">
        © {{ date('Y') }} mywebsite.com. All rights reserved.
      </div>

      <div class="footer-payments">
        <i class="fab fa-cc-visa"></i>
        <i class="fab fa-cc-mastercard"></i>
        <i class="fab fa-cc-amex"></i>
        <i class="fab fa-cc-paypal"></i>
      </div>

    </div>
  </div>
</footer>

<style>
  .shop-footer {
  background-color: #232f3e; /* Amazon dark */
  color: #ddd;
  font-size: 14px;
}

.footer-brand img {
  filter: brightness(1.1);
}

.footer-title {
  color: #fff;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 12px;
  text-transform: uppercase;
}

.footer-text {
  color: #bbb;
  line-height: 1.6;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 8px;
}

.footer-links a {
  color: #bbb;
  text-decoration: none;
  transition: color 0.2s ease;
}

.footer-links a:hover {
  color: #ff9900; /* Amazon accent */
  text-decoration: underline;
}

.footer-newsletter input {
  border-radius: 4px 0 0 4px;
  border: none;
}

.footer-newsletter button {
  border-radius: 0 4px 4px 0;
  font-weight: 600;
}

.footer-bottom {
  background-color: #131a22; /* Darker bar */
  color: #aaa;
  padding: 12px 0;
  font-size: 13px;
}

.footer-payments i {
  font-size: 24px;
  margin-left: 12px;
  color: #ccc;
  transition: color 0.2s ease;
}

.footer-payments i:hover {
  color: #ff9900;
}


/* About / Contact pages */
.info-card {
  background: #fff;
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.info-title {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 15px;
  color: #232f3e; /* Amazon header color */
}

.info-text {
  font-size: 0.95rem;
  color: #444;
  line-height: 1.7;
  margin-bottom: 12px;
}

.contact-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.contact-list li {
  padding: 8px 0;
  font-size: 0.95rem;
  color: #333;
  border-bottom: 1px solid #eee;
}

</style>