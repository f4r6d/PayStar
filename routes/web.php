<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [ProductController::class, 'home'])->name('home');

Route::resource('products', ProductController::class);


Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('cart/checkout', [CartController::class, 'checkoutForm'])->name('cart.checkout-form');
Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('cart/update/{product}', [CartController::class, 'update'])->name('cart.update');

Route::post('payment/callback', [PaymentController::class, 'verify'])->name('payment.verify');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/update_card_number', [ProfileController::class, 'updateCardNumber'])->name('profile.update-card-number');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
});

require __DIR__ . '/auth.php';

Route::prefix('storage')->group(function(){

    Route::fallback(function () {
        $filename = join('/', array_slice(request()->segments(),1));
        $path = storage_path('app/' . $filename);
    
        if (!File::exists($path)) {
            $path = storage_path('app/public/products/image/iphone-xs.png');
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    })->name('images.get');

});