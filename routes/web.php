<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Show login page
Route::get('/', function () {
    return view('login');
});

// Register user account
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('users.register');

// Login and Logout
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('reset-password');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])
    ->name('reset-password-form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password-process');

// Routes after login success
Route::middleware(['loginAuth'])->group(function () {

	// Categories
	Route::prefix('categories')->name('categories.')->group(function () {
		Route::get('/', [CategoryController::class, 'index'])->name('index');
		Route::get('/create', [CategoryController::class, 'create'])->name('create');
		Route::post('/store', [CategoryController::class, 'store'])->name('store');
		Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
		Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
		Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
		Route::get('/{id}/products', [CategoryController::class, 'show'])->name('products');
	});

	// Products
	Route::prefix('products')->name('products.')->group(function () {
		Route::get('/', [ProductController::class, 'index'])->name('index');
		Route::get('/create', [ProductController::class, 'create'])->name('create');
		Route::post('/store', [ProductController::class, 'store'])->name('store');
		Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
		Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
		Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
	});

});