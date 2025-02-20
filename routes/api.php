<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Transaction\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routas de nuestro APIRestFul del curso de Udemy
|
*/

/**
 * Buyers
 */
Route::resource('buyers', BuyerController::class)->only([
    'index' , 'show'
]);



/**
 * Categories
 */
Route::resource('categories' , CategoryController::class)->except([
    'create' , 'edit'
]);



/**
 * Products
 */
Route::resource('products' , ProductController::class)->only([
    'index' , 'show'
]);


/**
 * Transaction
 */
Route::resource('transactions' , TransactionController::class)->only([
    'index' , 'show'
]);


/**
 * Sellers
 */
Route::resource('sellers' , SellerController::class)->only([
    'index' , 'show'
]);



/**
 * Users
 */
Route::resource('users' , UserController::class)->except([
    'create' , 'edit'
]);
