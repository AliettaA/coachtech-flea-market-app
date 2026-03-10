<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// 認証不要
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{id}', [ItemController::class, 'show']);

// 認証後のリダイレクト
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証必要
Route::middleware(['auth', 'verified'])->group(function () {
    // 商品出品
    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);

    // いいね
    Route::post('/like/{item}', [LikeController::class, 'store']);
    Route::delete('/like/{item}', [LikeController::class, 'destroy']);

    // 購入
    Route::get('/purchase/address/{item}', [PaymentController::class, 'editAddress']);
    Route::post('/purchase/address/{item}', [PaymentController::class, 'updateAddress']);
    Route::get('/purchase/{item}', [PaymentController::class, 'create']);
    Route::post('/purchase/{item}', [PaymentController::class, 'store']);
    Route::get('/purchase/{item}/success', [PaymentController::class, 'success']);

    // コメント
    Route::post('/comment/{item}', [CommentController::class, 'store']);

    // マイページ
    Route::get('/mypage', [UserController::class, 'index']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('/mypage/profile', [UserController::class, 'update']);
});