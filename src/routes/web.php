<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// 認証不要
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{id}', [ItemController::class, 'show']);

// 認証必要
Route::middleware('auth')->group(function () {
    // 商品出品
    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);

    // いいね
    Route::post('/like/{item}', [LikeController::class, 'store']);
    Route::delete('/like/{item}', [LikeController::class, 'destroy']);

    // 購入
    Route::get('/purchase/{item}', [PaymentController::class, 'create']);
    Route::post('/purchase/{item}', [PaymentController::class, 'store']);

    // コメント
    Route::post('/comment/{item}', [CommentController::class, 'store']);

    // マイページ
    Route::get('/mypage', [UserController::class, 'index']);
    Route::get('/mypage/edit', [UserController::class, 'edit']);
    Route::post('/mypage/edit', [UserController::class, 'update']);

    // 配送先変更
    Route::get('/purchase/{item}/address', [PaymentController::class, 'editAddress']);
    Route::post('/purchase/{item}/address', [PaymentController::class, 'updateAddress']);
});
