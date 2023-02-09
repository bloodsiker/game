<?php

namespace App\Http\Controllers\Web;

use App\Models\Currency;
use App\Models\FaucetHistory;
use App\Models\PromoCode;
use App\Models\PromoCodeActive;
use App\Models\User;
use App\Models\UserStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class AccountController
 */
class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $currencies = Currency::where('is_active', true)->get();

        return view('account.info', compact('currencies'));
    }

    public function infoPlayer(Request $request)
    {
        $user = Auth::user();
        $statistics = UserStatistic::with('currency')->where('user_id', $user->id)->get();
        $invites = User::where('ref_id', $user->id)->count();
        $faucet = FaucetHistory::where(['user_id' => $user->id, 'type' => FaucetHistory::TYPE_F])->count();

        return view('account.player', compact('statistics', 'invites', 'faucet'));
    }

    public function reward(Request $request, $currency)
    {
        $currency = Currency::where('code', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $user = Auth::user();

        $prev = FaucetHistory::where('user_id', $user->id)->where('type', FaucetHistory::TYPE_F)->orderByDesc('id')->first();
        $diff = $prev ? $prev->date->diffInSeconds(Carbon::now()) : 180;

        if ($request->isMethod('POST')) {
            $amount = $request->get('amount');

            if ($diff < 180) {
                return back()->with(['error' => 'Слишком много запросов с одного и того же IP-адреса с интервалом в 3 минуты']);
            }

            if ($user->getBalance($currency->code) > 0) {
                return back()->with(['error' => 'Ваш баланс слишком велик для запроса крана.']);
            }

            $user->{$currency->code} = $amount;
            $user->save();

            $faucetHistory = new FaucetHistory();
            $faucetHistory->type = FaucetHistory::TYPE_F;
            $faucetHistory->amount = $amount;
            $faucetHistory->currency_id = $currency->id;
            $faucetHistory->user_id = $user->id;
            $faucetHistory->date = Carbon::now();
            $faucetHistory->save();

            return back()->with(['success' => 'Запрошенная сумма добавлена на ваш счет.']);
        }

        return view('account.reward', compact('currency', 'diff'));
    }

    public function getFaucetHistory(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type');
        $faucets = FaucetHistory::where(['user_id' => $user->id, 'type' => $type])->get();

        return view('account.faucet_history', compact('faucets', 'type'));
    }

    public function usePromoCode(Request $request)
    {
        if ($request->isMethod('POST')) {
            $user = Auth::user();

            $code = $request->get('promocode');

            if (!$code) {
                return back()->with(['error_promo' => 'Не введен промокод', 'tab' => 'promocode']);
            }

            $promoCode = PromoCode::where('code', $code)->first();
            if (!$promoCode) {
                return back()->with(['error_promo' => 'Не верный промокод', 'tab' => 'promocode']);
            }

            if ($promoCode->end_date < Carbon::now()) {
                return back()->with(['error_promo' => 'Промокод не действителен', 'tab' => 'promocode']);
            }

            $promoUse = PromoCodeActive::where('promo_code_id', $promoCode->id)->where('user_id', $user->id)->first();
            if ($promoUse) {
                return back()->with(['error_promo' => 'Вы уже использовали этот промокод', 'tab' => 'promocode']);
            }

            if ($promoCode->promo_code_activation()->count() > $promoCode->quantity) {
                return back()->with(['error_promo' => 'Превышено количество активаций промокода', 'tab' => 'promocode']);
            }

            $amount = $promoCode->discount;

            $user->setActiveBalance($promoCode->currency->code);
            $user->addToBalance($amount);

            PromoCodeActive::create([
                'user_id' => $user->id,
                'activation_date' => Carbon::now(),
                'promo_code_id' => $promoCode->id
            ]);

            $faucetHistory = new FaucetHistory();
            $faucetHistory->type = FaucetHistory::TYPE_O;
            $faucetHistory->amount = $amount;
            $faucetHistory->currency_id = $promoCode->currency->id;
            $faucetHistory->user_id = $user->id;
            $faucetHistory->description = sprintf('Промокод %s', $promoCode->code);
            $faucetHistory->date = Carbon::now();
            $faucetHistory->save();

            return back()->with(['success_promo' => sprintf('Вам начислено %s %s', $promoCode->discount, $promoCode->currency->name), 'tab' => 'promocode']);
        }
    }

    public function setting(Request $request)
    {
        return view('account.setting');
    }

    public function getBalance(Request $request)
    {
        $code = $request->get('code');

        $currency = Currency::where('code', $code)->first();

        return response()->json([
            'balance' => Auth::user()->{$code},
            'accuracy' => $currency->accuracy,
        ]);
    }
}
