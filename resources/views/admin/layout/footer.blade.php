<!-- Footer Section -->
<footer class="footer-section bg-light border-top pt-5">
  <div class="container">
    <div class="row">

      <!-- Logo & Copyright -->
      <div class="col-12 col-lg-3 mb-4 text-center text-lg-start">
        <a href="{{route('products.list')}}">
          <img src="{{ asset('images/mywebsiteimage.jpg') }}" height="50" alt="Logo" class="mb-2">
        </a>
        <p class="text-muted small">© 2023 mywebsite.com</p>
      </div>

      <!-- Store Links -->
      <div class="col-6 col-sm-4 col-lg-2 mb-4">
        <h6 class="text-dark fw-bold mb-3">Store</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">About Us</a></li>
          <li><a href="#">Find Store</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">Blogs</a></li>
        </ul>
      </div>

      <!-- Information Links -->
      <div class="col-6 col-sm-4 col-lg-2 mb-4">
        <h6 class="text-dark fw-bold mb-3">Information</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Money Refund</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">Refunds</a></li>
        </ul>
      </div>

      <!-- Support Links -->
      <div class="col-6 col-sm-4 col-lg-2 mb-4">
        <h6 class="text-dark fw-bold mb-3">Support</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Documents</a></li>
          <li><a href="#">Account Restore</a></li>
          <li><a href="#">My Orders</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="col-12 col-lg-3 mb-4">
        <h6 class="text-dark fw-bold mb-3">Newsletter</h6>
        <p class="text-muted small">Stay updated on latest products & offers</p>
        <div class="input-group newsletter-input">
          <input type="email" class="form-control" placeholder="Enter your email">
          <button class="btn btn-primary" type="button">Join</button>
        </div>
      </div>

    </div> <!-- row -->

    <!-- Bottom Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
      
      <!-- Payment Icons -->
      <div class="mb-3 mb-md-0 payment-icons">
        <i class="fab fa-cc-visa"></i>
        <i class="fab fa-cc-amex"></i>
        <i class="fab fa-cc-mastercard"></i>
        <i class="fab fa-cc-paypal"></i>
      </div>

      <!-- Language Selector -->
      <div class="dropdown dropup">
        <a class="dropdown-toggle text-dark" href="#" id="Dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="flag-united-kingdom me-1"></i>English
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="Dropdown">
          <li><a class="dropdown-item" href="#"><i class="flag-united-kingdom me-1"></i>English <i class="fa fa-check text-success ms-2"></i></a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#"><i class="flag-poland me-1"></i>Polski</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-china me-1"></i>中文</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-japan me-1"></i>日本語</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-germany me-1"></i>Deutsch</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-france me-1"></i>Français</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-spain me-1"></i>Español</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-russia me-1"></i>Русский</a></li>
          <li><a class="dropdown-item" href="#"><i class="flag-portugal me-1"></i>Português</a></li>
        </ul>
      </div>

    </div>
  </div>
</footer>

<!-- CSS -->
<style>
.footer-section {
  background: #f9f9f9;
  color: #555;
  font-family: 'Segoe UI', sans-serif;
}
.footer-section h6 {
  font-size: 0.95rem;
  letter-spacing: 0.5px;
}
.footer-links li a {
  display: block;
  color: #6c757d;
  text-decoration: none;
  margin-bottom: 8px;
  transition: all 0.3s;
}
.footer-links li a:hover {
  color: #007bff;
  text-decoration: underline;
}
.newsletter-input input {
  border-radius: 30px 0 0 30px;
  border: 1px solid #ced4da;
  padding: 0.5rem 1rem;
}
.newsletter-input button {
  border-radius: 0 30px 30px 0;
  background: #007bff;
  color: #fff;
  border: 1px solid #007bff;
  padding: 0.5rem 1.5rem;
  transition: all 0.3s;
}
.newsletter-input button:hover {
  background: #0056b3;
}
.payment-icons i {
  font-size: 1.5rem;
  margin-right: 10px;
  color: #6c757d;
  transition: all 0.3s;
}
.payment-icons i:hover {
  color: #007bff;
}
.dropdown-toggle::after {
  margin-left: 0.5rem;
}
@media(max-width: 767px) {
  .footer-section .newsletter-input {
    flex-direction: column;
  }
  .newsletter-input input, .newsletter-input button {
    border-radius: 30px;
    width: 100%;
    margin-bottom: 0.5rem;
  }
}
</style>
