<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FarmerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

// Catálogo público
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/agricultores/{user}', [FarmerController::class, 'show'])->name('farmers.show');

// Comparar Productos
Route::get('/comparar', [CompareController::class, 'index'])->name('compare.index');
Route::post('/comparar/agregar/{product}', [CompareController::class, 'add'])->name('compare.add');
Route::post('/comparar/quitar/{product}', [CompareController::class, 'remove'])->name('compare.remove');
Route::post('/comparar/limpiar', [CompareController::class, 'clear'])->name('compare.clear');

// Carrito de Compras (Gestión y almacenamiento en sesión)
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/actualizar/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/carrito/quitar/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/limpiar', [CartController::class, 'clear'])->name('cart.clear');

Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Pedidos (Cliente)
    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout'); // Vista de checkout
    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate'); // Procesar pago
    Route::get('/payment/transfer/{order}', [PaymentController::class, 'transfer'])->name('payment.transfer'); // Página de transferencia
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success'); // Éxito de MP
    Route::get('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure'); // Fallo de MP
    
    // Reseñas de producto
    Route::post('/productos/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favoritos/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favoritos/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Pantalla de Éxito al Registrarse
    Route::get('/registro-exitoso', function () {
        return view('auth.register-success');
    })->name('register.success');
});

// Panel de Vendedor
Route::middleware(['auth', 'role:seller'])->prefix('vendedor')->name('seller.')->group(function () {
    Route::get('productos/mios', [ProductController::class, 'sellerIndex'])->name('productos.index');
    Route::resource('productos', ProductController::class)->except(['index', 'show']);
});

// Panel de Administrador
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categorias', CategoryController::class);
    // Además gestión global
    Route::get('pedidos', [OrderController::class, 'adminIndex'])->name('orders.all');
    Route::post('pedidos/{order}/transferencia/pagar', [PaymentController::class, 'markTransferAsPaid'])->name('orders.transfer.pay');
});

// Panel común para los perfiles internos de la plataforma
Route::get('/equipo', function () {
    return view('staff.dashboard');
})->middleware([
    'auth',
    'role:support,order_manager,moderator,farmer_verifier,payment_manager,quality_manager,promotion_manager,analyst,super_admin,technician,certifier',
])->name('staff.dashboard');

require __DIR__.'/auth.php';
