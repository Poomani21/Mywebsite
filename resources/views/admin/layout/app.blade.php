<!--Main Navigation-->

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Site Title -->
    <title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/Copilot_20260309_145910.png') }}">

    <!-- Open Graph (Facebook / WhatsApp) -->
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:description" content="Shop the best products online. Fast delivery and secure payment.">
    <meta property="og:image" content="{{ asset('images/Copilot_20260309_145910.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name') }}">
    <meta name="twitter:description" content="Shop the best products online.">
    <meta name="twitter:image" content="{{ asset('images/Copilot_20260309_145910.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>  -->
    
</head>
<header>
@include('admin.layout.header')
</header>
<body>
<section>
  <div class="container my-5">
@yield('content')
</div>
</section>
<section class="mt-5" style="background-color: #f5f5f5;">
  <div class="container text-dark pt-3">
@include('admin.layout.side_bar')
</div>
  <!-- container end.// -->
</section>

<!-- Blog -->
<section class="mt-5 mb-4">
  <div class="container text-dark">
{{-- @include('admin.layout.nav_bar') --}}
</div>
</section>
<!-- Blog -->
<!-- Footer -->
<footer class="text-center text-lg-start text-muted mt-3" style="background-color: #f5f5f5;">
@include('admin.layout.footer')
</footer>
<!-- Footer -->
@yield('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<style>
    .icon-hover:hover {
  border-color: #3b71ca !important;
  background-color: white !important;
}

.icon-hover:hover i {
  color: #3b71ca !important;
}

.policy-page {
    background: #f5f6f8;
    padding: 40px 0;
    min-height: 70vh;
}

.policy-container {
    background: #fff;
    border-radius: 10px;
    padding: 30px 35px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.policy-container h1 {
    font-size: 28px;
    font-weight: 700;
    color: #232f3e; /* matches your header */
    margin-bottom: 20px;
    border-bottom: 2px solid #ff9900;
    padding-bottom: 10px;
}

.policy-container h2 {
    font-size: 18px;
    margin-top: 25px;
    margin-bottom: 10px;
    color: #111;
    font-weight: 600;
}

.policy-container p,
.policy-container li {
    color: #555;
    line-height: 1.7;
    font-size: 15px;
}

.policy-container ul {
    padding-left: 20px;
}

.policy-container li {
    margin-bottom: 8px;
}


.help-page {
    background: #f5f6f8;
    padding: 40px 0;
    min-height: 70vh;
}

.help-container {
    background: #fff;
    border-radius: 10px;
    padding: 30px 35px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.help-container h1 {
    font-size: 28px;
    font-weight: 700;
    color: #232f3e; /* matches your header */
    margin-bottom: 20px;
    border-bottom: 2px solid #ff9900;
    padding-bottom: 10px;
}

.help-container h2 {
    font-size: 18px;
    margin-top: 25px;
    margin-bottom: 10px;
    color: #111;
    font-weight: 600;
}

.help-container p,
.help-container li {
    color: #555;
    line-height: 1.7;
    font-size: 15px;
}

.help-container ul {
    padding-left: 20px;
}

.help-container li {
    margin-bottom: 8px;
}

</style>


