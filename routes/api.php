<?php

use App\Http\Controllers\Api\V1\MineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::get('test', [MineController::class, 'test']);
    Route::post('mines/create', [MineController::class, 'create']);
    Route::post('mines/rates', [MineController::class, 'rates']);
    Route::post('mines/play', [MineController::class, 'play']);
    Route::post('mines/collect', [MineController::class, 'collect']);
});

//Route::group(['middleware' => ['web']], function () {
//
//    Route::get('test', [MineController::class, 'create']);
//    Route::match(['post', 'get'], 'test', [LoginController::class, 'test']);
//    Route::match(['post', 'get'], 'curl', [LoginController::class, 'curl']);
//
//    Route::match(['post', 'get'], '/', [LoginController::class, 'login'])->name('login');
//
//    Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
//        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
//
//        Route::match(['post', 'get'], 'edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
//        Route::get('logout', [ProfileController::class, 'logout'])->name('admin.logout');
//
//        Route::get('exchange-source', [ExchangeSourceController::class, 'list'])->name('admin.exchange_source');
//        Route::match(['post', 'get'], 'exchange-source/{id}/edit', [ExchangeSourceController::class, 'edit'])->name('admin.exchange_source.edit');
//        Route::match(['post', 'get'], 'exchange-source/add', [ExchangeSourceController::class, 'add'])->name('admin.exchange_source.add');
//        Route::get('exchange-source/{id}/delete', [ExchangeSourceController::class, 'delete'])->name('admin.exchange_source.delete');
//
//        Route::post('exchange-ajax', [ExchangeController::class, 'ajax'])->name('admin.exchange.ajax');
//        Route::get('exchange', [ExchangeController::class, 'list'])->name('admin.exchange');
//        Route::match(['post', 'get'], 'exchange/{id}/edit', [ExchangeController::class, 'edit'])->name('admin.exchange.edit');
//        Route::match(['post', 'get'], 'exchange/add', [ExchangeController::class, 'add'])->name('admin.exchange.add');
//        Route::get('exchange/{id}/delete', [ExchangeController::class, 'delete'])->name('admin.exchange.delete');
//    });
//});
