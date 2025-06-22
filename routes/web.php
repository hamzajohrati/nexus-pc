<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;



Route::get('/', 'homeController@index')->name('home');
Route::get('/login', 'AuthController@showLoginForm')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->name('logout');
Route::get('/register', 'AuthController@showRegisterForm')->name('register');
Route::post('/register', 'AuthController@register');
Route::get('/components','ComponentsController@index' )->name('components');
Route::get('/prebuilt-pcs','PreBuiltPCController@index')->name('prebuilt');
Route::get('/pc-builder', 'PCBuilderController@index')->name('builder');
Route::post('/pc-builder/add-cart', 'PCBuilderController@add')->name('builder.add');



//Cart Routes
Route::controller('CartController')->group(function () {
    Route::post('cart/pc/{id}',        'addPC'   )->name('cart.pc');
    Route::post('cart/component/{id}', 'addComp' )->name('cart.component');
    Route::patch('cart/{rowId}',       'update'  )->name('cart.update');
    Route::delete('cart/{rowId?}',     'remove'  )->name('cart.remove'); // rowId null = clear all
    Route::get('cart',                 'index'   )->name('cart');
});

//Authed Routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
    Route::post('checkout', 'CheckoutController@store')->name('checkout');
});



//Admin Routes
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){

    Route::get('/', 'Admin\\DashboardController@index')->name('dashboard.index');

    Route::resource('categories', 'Admin\\CategoryController');
    Route::resource('components', 'Admin\\ComponentController');
    Route::resource('pcs', 'Admin\\PcController');
    Route::resource('users', 'Admin\\UserController');
    Route::resource('requests', 'Admin\\RequestController');
    Route::resource('config', 'Admin\\ConfigController');

});
