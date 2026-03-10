<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Mail;

//Auth routes

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::get('forgot-password', [AuthController::class, 'showForgotForm'])
        ->name('forgotPassword');

Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
        ->name('forgotPassword.post');

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::match(['get','post'], 'logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [ProductController::class, 'productList'])->name('products.list');

Route::view('/policy/return', 'policies.return')->name('policy.return');
Route::view('/policy/terms', 'policies.terms')->name('policy.terms');
Route::view('/policy/privacy', 'policies.privacy')->name('policy.privacy');
Route::view('/policy/security', 'policies.security')->name('policy.security');


Route::view('/help', 'pages.help')->name('help');
Route::view('/payments', 'pages.payments')->name('payments');
Route::view('/shipping', 'pages.shipping')->name('shipping');
Route::view('/cancellation', 'pages.cancellation')->name('cancellation');
Route::view('/returns', 'pages.returns')->name('returns');
Route::view('/about-us', 'pages.about')->name('about');
Route::view('/contact-us', 'pages.contact')->name('contact');




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('home', [ProductController::class, 'productList'])->name('products.list');
Route::get('/', [ProductController::class, 'productList'])->name('products.list');

Route::get('/mongo-test', function () {
    \App\Models\Product::create([
        'name' => 'Render Test',
        'price' => 123
    ]);
    return 'Mongo OK';
});


Route::middleware('auth')->group(function() {

//cart routes

Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('removeCart', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('remove', [CartController::class, 'remove'])->name('cart.remove.list');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
Route::get('/cart/total-quantity', [CartController::class, 'getTotalQuantity'])->name('cart.getTotalQuantity');


//product routes


Route::get('productCreate', [ProductController::class, 'productCreate'])->name('product.create');
Route::post('productStore', [ProductController::class, 'productStore'])->name('product.store');
Route::get('productlist', [ProductController::class, 'index'])->name('product.index');
Route::put('product/{id}', [ProductController::class, 'productUpdate'])->name('product.update');
Route::delete('product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

//paypal credential routes

Route::get('handle-payment/{total_amount_price}',[PaypalController::class,'handlePayment'])->name('make.payment');
Route::get('payment-success',[PaypalController::class,'paymentSuccess'])->name('payment.success');
Route::get('payment-failed',[PaypalController::class,'paymentFailed'])->name('payment.failed');


//address routes

 // Show add address page / modal
 Route::get('/address_create', [AddressController::class, 'create'])->name('address.add');

 // Store new address
 Route::post('/address_store', [AddressController::class, 'store'])->name('address.store');

 // List addresses (optional page)
 Route::get('/addresses', [AddressController::class, 'index'])->name('address.index');

 // Delete address
 Route::post('/address_delete/{id}', [AddressController::class, 'destroy'])->name('address.delete');

 // Set default address
 Route::post('/address_default/{id}', [AddressController::class, 'setDefault'])->name('address.default');

 // Delivery estimate for cart (AJAX)
 Route::get('/cart/delivery-estimate/{addressId}', [AddressController::class, 'deliveryEstimate'])
     ->name('cart.delivery.estimate');

//Orders
Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

Route::post('/pay-with-card', [PaypalController::class, 'payWithCard'])->name('stripe.intent');
Route::post('/stripe/success', [PaypalController::class, 'stripeSuccess'])->name('stripe.success');

Route::get('exportPdf', [OrderController::class, 'exportPdf'])->name('orders.pdf');

//Account Info Routes
Route::get('accountInfo', [AccountController::class, 'edit'])->name('account.info');
Route::post('accountInfo/update', [AccountController::class, 'update'])->name('account.update');
Route::delete('accountInfo/delete', [AccountController::class, 'destroy'])->name('account.delete');


Route::get('/testsms', function () {
    \App\Services\OrderNotificationService::sendSMS(
        '9578777149',
        'Test SMS from Laravel'
    );
});

Route::get('/test-mail', function () {

    Mail::raw('Test Mail from Render', function ($message) {
        $message->to('spoomani21@gmail.com')
                ->subject('Render Mail Test');
    });

    return "Mail Sent";
});

});
