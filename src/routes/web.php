<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;


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

Route::get('/', [ItemController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get('/mypage/profile', [MypageController::class, 'edit'])
        ->name('mypage.profile.edit');

    Route::patch('/mypage/profile', [MypageController::class, 'update'])
    ->name('mypage.profile.update');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');

    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');

    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchase.create');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'edit']) ->name('purchase.address.edit');


});

Route::get('/item/{item}', [ItemController::class, 'show'])
    ->name('items.show');