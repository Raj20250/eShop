<?php
use App\Http\Controllers\Auth\Admin\AdminAuthController;
use App\Http\Controllers\Auth\Admin\AdminUserController;
use App\Http\Controllers\Auth\Admin\DashboardController;
use App\Http\Controllers\Auth\Admin\OrderController;
use App\Http\Controllers\Auth\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\Admin\QuerieController as AdminQuerieController;
use App\Http\Controllers\Auth\Client\CartController;
use App\Http\Controllers\Auth\Client\CheckoutController;
use App\Http\Controllers\Auth\Client\ClientAuthController;
use App\Http\Controllers\Auth\Client\OrderHistoryController;
use App\Http\Controllers\Auth\Client\OrderStatusController;
use App\Http\Controllers\Auth\Client\WishlistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController as ClientProductController;
use App\Http\Controllers\QuerieController as ClientQuerieController;
use Illuminate\Support\Facades\Route;

// 
Route::get('/', [ClientProductController::class, 'index'])->name('home');
Route::get('product-detail/{product}', [ClientProductController::class, 'productDetail'])->name('product.detail');

//
Route::get('show-query', [ClientQuerieController ::class, 'index'])->name('client.show-query');
Route::post('submit-query', [ClientQuerieController ::class, 'store'])->name('client.submit-query');
Route::get('/query-answer/{id}', [ClientQuerieController::class, 'showAnswer'])->name('query.answer');
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us'); 





//
Route::middleware('guest')->group(function () {
    // Client Auth
    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientAuthController::class, 'login']);
    Route::get('/register', [ClientAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [ClientAuthController::class, 'register']);

    // Admin Login
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('login.post');
});
//
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [ClientAuthController::class, 'logout'])->name('logout');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

//
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin'])->group(function () {
   // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard', DashboardController::class);

//
      Route::get('/profile', function () {
        return view('auth.admin.show-profile');
    })->name('profile');
    // Route to display the edit profile form
Route::get('/profile/edit', [AdminAuthController::class, 'editProfile'])->name('profile.edit');

// Route to handle the actual update logic (using PUT or PATCH method)
Route::put('/profile/update', [AdminAuthController::class, 'updateProfile'])->name('profile.update');

 // Route to handle the password update logic
Route::put('/profile/password', [AdminAuthController::class, 'updatePassword'])->name('password.update');

// 
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('queries', AdminQuerieController::class);

});




// Client Routes 

Route::middleware(['auth', 'client'])->group(function () {

    // Client Dashboard
    Route::get('/dashboard', function () {
        return view('auth.client.client-dashboard');
    })->name('client.dashboard');

    // Client Profile
    Route::get('/profile', function () {
        return view('auth.client.profile');
    })->name('profile');

    // Route to display the edit profile form
Route::get('/profile/edit', [ClientAuthController::class, 'editProfile'])->name('profile.edit');

// Route to handle the actual update logic (using PUT or PATCH method)
Route::put('/profile/update', [ClientAuthController::class, 'updateProfile'])->name('profile.update');

Route::put('/profile/password', [ClientAuthController::class, 'updatePassword'])->name('client.password.update');

   

    Route::get('/order-history', [OrderHistoryController::class,'index'])
    ->name('order.history');

      Route::get('/order-status', [OrderStatusController::class,'index'])
    ->name('order.status'); 

      

     

    // Order Detail Route
    Route::get('/order-detail/{id}', [OrderHistoryController::class,'show'])
    ->name('order.detail'); 
    
    Route::get('checkout', [CheckoutController::class,'index'])
    ->name('checkout');
    
    // Place Order Route
    Route::post('checkout/place-order', [CheckoutController::class,'placeOrder'])
    ->name('checkout.place-order');
   
    Route::get('order/success', [CheckoutController::class,'orderSuccess'])
    ->name('order.success');



    // Cart Routes
Route::get('carts', [CartController::class,'index'])->name('carts');    
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');
Route::get('/api/products/{id}', [CartController::class, 'getProduct'])->name('products.api');


// Wishlist Routes
Route::get('/wishlist', [WishlistController::class,'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add')->middleware('auth');     
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove')->middleware('auth');


});


Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');


