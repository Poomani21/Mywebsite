
<style>
    /* Made with love by Mutiullah Samim*/

@import url('https://fonts.googleapis.com/css?family=Numans');

.card-body{
    flex: 1 1 auto;
}

.card-footer{
    margin-top: auto;
}

html,body{
background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;
}

.container{
height: 100%;
align-content: center;
}

.card{
margin-top: auto;
margin-bottom: auto;
width: 400px;
min-height: 370px;
background-color: rgba(0,0,0,0.5) !important;
display: flex;
flex-direction: column;
}

.social_icon span{
font-size: 60px;
margin-left: 10px;
color: #FFC312;
}

.social_icon span:hover{
color: white;
cursor: pointer;
}

.card-header h3{
color: white;
}

.social_icon{
position: absolute;
right: 20px;
top: -45px;
}

.input-group-prepend span{
width: 50px;
background-color: #FFC312;
color: black;
border:0 !important;
}

input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}

.remember{
color: white;
}

.remember input
{
width: 20px;
height: 20px;
margin-left: 15px;
margin-right: 5px;
}

.login_btn{
color: black;
background-color: #FFC312;
width: 100px;
}

.login_btn:hover{
color: black;
background-color: white;
}

.links{
color: white;
}

.links a{
margin-left: 4px;
}

/* ================= MOBILE RESPONSIVE ================= */
@media (max-width: 576px) {

html, body {
    background-position: center;
    background-size: cover;
}

.card {
    width: 90%;
    height: auto;
    margin: 20px;
    padding-bottom: 15px;
}

.card-header h3 {
    font-size: 22px;
    text-align: center;
}

.social_icon {
    position: static;
    text-align: center;
    margin-top: 10px;
}

.social_icon span {
    font-size: 40px;
    margin: 0 8px;
}

.input-group-prepend span {
    width: 40px;
    font-size: 14px;
}

.form-control {
    font-size: 14px;
    height: 40px;
}

.login_btn {
    width: 100%;
    margin-top: 10px;
}

.links {
    text-align: center;
    font-size: 14px;
}

.links a {
    display: inline-block;
    margin-top: 5px;
}

.float-left {
    float: none !important;
    display: block;
    text-align: center;
    margin-bottom: 10px;
}

.float-right {
    float: none !important;
}
}
@media (max-width: 576px){

.card{
    width: 95%;
    margin: 15px auto;
}

}

/* Logo alignment */
.logo-container{
    text-align:center;
    margin-bottom:-65px; /* desktop gap reduce */
}

.login-logo{
    width:200px;
    height:auto;
}

/* spacing for header */
.card-header{
    text-align:center;
    border-bottom:none;
    padding-top:0px;
    padding-bottom:5px;
}

.card-header h3{
    margin:0;
}

/* Card styling */
.card{
    min-height:420px;
    margin-top:auto;
    margin-bottom:auto;
    width:400px;
    background-color: rgba(0,0,0,0.55) !important;
    border-radius:10px;
    padding-bottom:15px;
}


/* 📱 Mobile view */
@media (max-width:576px){

.logo-container{
    margin-bottom:-25px; /* reduce negative margin for mobile */
}

.login-logo{
    width:150px;
}

.card{
    width:92%;
    margin:40px auto;
    padding:15px;
}

.card-header h3{
    font-size:20px;
}

}

</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!DOCTYPE html>
<html>

<head>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    

</head>

<body>
    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            };
            toastr.error("{{ $errors->first() }}");
        });
        </script>
    @endif
    @if (session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };
    toastr.success("{{ session('success') }}");
});
</script>
@endif


    <div class="container">
        <div class="d-flex justify-content-center h-77">
            <div class="card" style="">

                <div class="logo-container">
                    <img src="{{ asset('images/Copilot_20260309_145910.png') }}" 
                         alt="Logo" 
                         class="login-logo">
                </div>

                <div class="card-header">
                    <h3>Register</h3>
                    {{-- <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf


                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" id="name" class="form-control" name="name"
                                placeholder="User Name" required autofocus>
                                {{-- @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif --}}
                        </div>


                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope-square"></i></span>
                            </div>
                            <input type="email" id="email_address" class="form-control" name="email"
                                placeholder="Email Address" required autofocus>
                                {{-- @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif --}}
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="password" required>
                                {{-- @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif --}}

                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="number" id="phone" class="form-control" name="phone"
                                placeholder="phone number" oninput="this.value=this.value.slice(0,10)" required>

                        </div>
                        <!-- <div class="row align-items-center remember">
                            <input type="checkbox" name="remember">Remember Me
                        </div> -->
                        <div>
                        <a href="{{ route('products.list') }}"
                        class="float-left"
                        style="color: #FFC312">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                fill="currentColor"
                                viewBox="0 0 18 18"
                                class="mr-2">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 
                                    0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                            </svg>Go Back
                        </a>
                        <div class="form-group" style=" ">
                            <input type="submit" value="Register" class="btn float-right login_btn">
                        </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        I have already an account?<a href="{{ route('login') }}">Login</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('forgotPassword') }}">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
