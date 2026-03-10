
<style>
    /* Made with love by Mutiullah Samim*/

@import url('https://fonts.googleapis.com/css?family=Numans');

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
height: 370px;
margin-top: auto;
margin-bottom: auto;
width: 400px;
background-color: rgba(0,0,0,0.5) !important;
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

/* 📱 Mobile responsive */
@media (max-width: 576px) {

.card {
    width: 95% !important;   /* full width on mobile */
    height: auto !important; /* auto height */
    margin: 20px auto;
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
    font-size: 30px;
    margin: 0 5px;
}

.input-group-prepend span {
    width: 40px;
}

.form-group {
    width: 100% !important;
    padding: 0;
}

.login_btn {
    width: 100%;
}

.links {
    text-align: center;
    flex-direction: column;
}

.links a {
    margin-left: 0;
    margin-top: 5px;
    display: inline-block;
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
        <div class="d-flex justify-content-center h-55">
            <div class="card" style="height: 383px;">

                <div class="logo-container">
                    <img src="{{ asset('images/Copilot_20260309_145910.png') }}" 
                         alt="Logo" 
                         class="login-logo">
                </div>

                <div class="card-header">
                    <h3>Forgot Password</h3>
                    {{-- <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('forgotPassword.post') }}" method="POST">
                        @csrf

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope-square"></i></span>
                            </div>
                            <input type="email" id="email_address" class="form-control" name="email"
                                placeholder="Email Address" value="" required>
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
                            <input type="password" id="confirm-password" class="form-control" name="confirm-password"
                                placeholder="confirm password" required>
                                {{-- @if ($errors->has('confirm-password'))
                                <span class="text-danger">{{ $errors->first('confirm-password') }}</span>
                            @endif --}}

                        </div>
                        <!-- <div class="row align-items-center remember">
                            <input type="checkbox" name="remember">Remember Me
                        </div> -->
                        <div class="form-group" style=" margin: auto;width: 50%;padding: 10px;">
                            <input type="submit" value="Register" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        I have already an account?<a href="{{ route('login') }}">Login</a>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</body>

</html>
