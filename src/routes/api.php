<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\OrderStatusesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/checkAuth', [AuthController::class, 'checkAuth']);
Route::get('products/category/{category}', [ProductsController::class, 'getProductsByCategory']);

Route::resource('users', UserController::class);
Route::resource('products', ProductsController::class);
Route::resource('orders', OrdersController::class);

Route::put('/orders/{orderId}/payment-status', [PaymentsController::class, 'updatePaymentStatus']);

Route::put('/orders/{orderId}/order-status', [OrderStatusesController::class, 'updateOrderStatus']);
