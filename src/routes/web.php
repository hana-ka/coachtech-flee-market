<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/mypage/profile', [MypageController::class, 'edit'])
        ->name('mypage.profile.edit');

    Route::patch('/mypage/profile', [MypageController::class, 'update'])
        ->name('mypage.profile.update');

    Route::get('/mypage', [MypageController::class, 'index'])
        ->name('mypage');


    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');

    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');


    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'edit'])
        ->name('purchase.address.edit');

    Route::post('/purchase/address/{item}', [PurchaseController::class, 'update'])
        ->name('purchase.address.update');

    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store');

    Route::get('/purchase/success/{item}', [PurchaseController::class, 'success'])
        ->name('purchase.success');


    Route::post('/like/{item}', [LikeController::class, 'store'])
        ->name('like.store');

});

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
        })->name('verification.notice');


    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back();
    })->name('verification.send');


    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/mypage/profile');
    })->middleware('signed')
        ->name('verification.verify');

});


Route::get('/item/{item}', [ItemController::class, 'show'])
    ->name('items.show');

Route::post('/comment/{item}', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');