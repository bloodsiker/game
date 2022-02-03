<?php

namespace App\Http\Controllers\Web;

use App\Models\Currency;
use App\Models\FaucetHistory;
use App\Models\Mine;
use App\Models\MineRate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

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

        return view('account.player');
    }

    public function reward(Request $request, $currency)
    {
        $currency = Currency::where('idc', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $user = Auth::user();

        $prev = FaucetHistory::where('user_id', $user->id)->where('type', FaucetHistory::TYPE_F)->orderByDesc('id')->first();
        $diff = $prev->date->diffInSeconds(Carbon::now());

        if ($request->isMethod('POST')) {
            $amount = $request->get('amount');

            if ($diff < 180) {
                return back()->with(['error' => 'Слишком много запросов с одного и того же IP-адреса с интервалом в 3 минуты']);
            }

            if ($user->getBalance($currency->idc) > 0) {
                return back()->with(['error' => 'Ваш баланс слишком велик для запроса крана.']);
            }

            $user->{$currency->idc} = $amount;
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
        return view('account.faucet_history');
    }

    public function getBalance(Request $request)
    {
        $currency = $request->get('idc');

        return response()->json([
            'd' => Auth::user()->{$currency},
        ]);
    }
}
