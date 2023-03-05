<?php

use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\DepositController;
use App\Http\Controllers\Web\Game\CardController;
use App\Http\Controllers\Web\Game\CoinFlipController;
use App\Http\Controllers\Web\Game\DiceController;
use App\Http\Controllers\Web\Game\DiceV2Controller;
use App\Http\Controllers\Web\Game\KenoController;
use App\Http\Controllers\Web\Game\MineController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\MainController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\WithdrawController;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['web']], function () {
    Route::get('/', [MainController::class, 'index'])->name('index');

    Route::match(['post', 'get'], 'login', [LoginController::class, 'login'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::match(['post', 'get'], 'register', [RegisterController::class, 'index'])->name('register');

    Route::group(['middleware' => ['auth']], function () {
        Route::post('/dice/getDiceResult', [DiceController::class, 'getDiceResult'])->name('getDiceResult');
        Route::post('/dice/getLastBets', [DiceController::class, 'getLastBets'])->name('getDiceLastBets');
        Route::get('/dice/getBet/{id}', [DiceController::class, 'getBet'])->name('getBetDice');

        Route::post('/keno/getKenoResult', [KenoController::class, 'getKenoResult'])->name('getKenoResult');
        Route::post('/keno/getLastBets', [KenoController::class, 'getLastBets'])->name('getKenoLastBets');
        Route::post('/keno/getRates', [KenoController::class, 'getRates'])->name('getKenoRates');

        Route::post('/mines/getRates', [MineController::class, 'getRates'])->name('getMineRates');
        Route::post('/mines/create', [MineController::class, 'create']);
        Route::post('/mines/play', [MineController::class, 'play']);
        Route::post('/mines/collect', [MineController::class, 'collect']);
        Route::post('/mines/getLastBets', [MineController::class, 'getLastBets'])->name('getMinesLastBets');
        Route::get('/mines/getBet/{id}', [MineController::class, 'getBet'])->name('getBetMine');

        Route::post('/coinflip/create', [CoinFlipController::class, 'create']);
        Route::post('/coinflip/play', [CoinFlipController::class, 'play']);
        Route::post('/coinflip/collect', [CoinFlipController::class, 'collect']);
        Route::post('/coinflip/getLastBets', [CoinFlipController::class, 'getLastBets'])->name('getCoinLastBets');

        Route::post('/cards/create', [CardController::class, 'create']);
        Route::post('/cards/play', [CardController::class, 'play']);
        Route::post('/cards/collect', [CardController::class, 'collect']);
        Route::post('/cards/load', [CardController::class, 'load']);
        Route::post('/cards/extraCard', [CardController::class, 'extraCard']);
        Route::post('/cards/getLastBets', [CardController::class, 'getLastBets'])->name('getCardLastBets');

        Route::post('/getBalance', [AccountController::class, 'getBalance'])->name('getBalance');
        Route::post('/getFaucetHistory', [AccountController::class, 'getFaucetHistory'])->name('getFaucetHistory');

        Route::get('/deposit/{currency}', [DepositController::class, 'index'])->name('deposit');
        Route::get('/withdraw/{currency}', [WithdrawController::class, 'index'])->name('withdraw');

        Route::get('/account/info', [AccountController::class, 'index'])->name('account.info');
        Route::get('/account/player', [AccountController::class, 'infoPlayer'])->name('account.player');
        Route::post('/account/promocode', [AccountController::class, 'usePromoCode'])->name('account.promocode');
        Route::match(['post', 'get'],'/account/setting', [AccountController::class, 'setting'])->name('account.setting');
        Route::match(['post', 'get'],'/account/reward/{currency}', [AccountController::class, 'reward'])->name('account.reward');
    });


    Route::post('/dice/getAllLastBets', [DiceController::class, 'getAllLastBets'])->name('getDiceAllLastBets');
    Route::post('/keno/getAllLastBets', [KenoController::class, 'getAllLastBets'])->name('getKenoAllLastBets');
    Route::post('/mines/getAllLastBets', [MineController::class, 'getAllLastBets'])->name('getMinesAllLastBets');
    Route::post('/coinflip/getAllLastBets', [CoinFlipController::class, 'getAllLastBets'])->name('getCoinAllLastBets');

    Route::get('/dice/{currency}', [DiceController::class, 'index'])->name('dice');
    Route::get('/dicev2/{currency}', [DiceV2Controller::class, 'index'])->name('dice_v2');
    Route::get('/mines/{currency}', [MineController::class, 'index'])->name('mines');
    Route::get('/coinflip/{currency}', [CoinFlipController::class, 'index'])->name('coinflip');
    Route::get('/cards/{currency}', [CardController::class, 'index'])->name('cards');
    Route::get('/keno/{currency}', [KenoController::class, 'index'])->name('keno');


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
});
