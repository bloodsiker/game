<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Models\Game;
use App\Models\KenoHistory;
use App\Models\KenoRate;
use App\Models\Mine;
use App\Models\MineRate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class KenoController
 */
class KenoController extends Controller
{
    protected $game;

    public function __construct()
    {
        $this->game = Game::where('name', 'Keno')->first();
    }

    public function index(Request $request, $currency)
    {
        $currency = Currency::where('idc', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $game = $this->game;

        return view('games.keno.index', compact('currency', 'game'));
    }

    public function getKenoResult(Request $request)
    {
        $user = Auth::user();
        $idc = $request->get('idc');
        $bet = (float) $request->get('bet');
        $clientseed = $request->get('clientseed');

        $numbers = array_map(function ($v) {
            return $v * 1;
        }, (array) $request->get('numbers'));

        $count = count($numbers);

        $user->setActiveBalance($idc);

        if ($bet > $user->getActiveBalance()) {
            $error = 'Ставка больше вашего баланса.';
            return false;
        }

        $currency = Currency::where('idc', $idc)->first();

        $user->setActiveBalance($idc);

        $generateNumbers = [];
        while (count($generateNumbers) < 10) {
            $rand = $this->randomNumbers(1, 36);
            if (!in_array($rand, $generateNumbers)) {
                $generateNumbers[] = $rand;
            }
        }

        $winNumbers = array_intersect($generateNumbers, $numbers);
        $winNumbers = array_values($winNumbers);
        $countWinNumbers = count($winNumbers);

        if ($countWinNumbers === 0) {
            $coeff = 0.00;

            $winAmount = -1 * $bet;

            $winAmount = (float) sprintf("%0.2f", $winAmount);

            $user->writeOffBalance($bet);
        } else {
            $rate = KenoRate::where(['number' => $count, 'count_win' => $countWinNumbers])->first();
            $coeff = $rate->coeff;

            if ($coeff > 0) {
                $winAmount = $bet * $coeff;
                $winAmount = (float) sprintf("%0.2f", $winAmount);

                $user->addToBalance($winAmount - $bet);
            } else {
                $winAmount = -1 * $bet;
                $winAmount = (float) sprintf("%0.2f", $winAmount);

                $user->writeOffBalance($bet);
            }
        }

        $kenoHistory = KenoHistory::create([
            'user_id'     => $user->id,
            'currency_id' => $currency->id,
            'bet'         => $bet,
            'profit'      => $winAmount,
            'coeff'       => $coeff,
            'user_numbers' => json_encode($numbers),
            'drop_numbers' => json_encode($generateNumbers),
            'win_numbers' => json_encode($winNumbers),
            'remainder'   => $user->getActiveBalance(),
            'time_game'   => Carbon::now(),
        ]);

        return response()->json([
            'd' => [
                'bet' => $bet,
                'numbers' => $numbers,
                'drop' => $generateNumbers,
                'win' => $winNumbers,
                'balance' => $user->getActiveBalance(),
                'win_amount' => $winAmount,
                'coeff' => $coeff,
                'idc' => $idc,
                'longid' => null,
                'comment' => null,
                'client_seed' => null,
                'result' => true,
                'id' => $kenoHistory->id,
                'NextServerSeedSHA256' => 'c8c7ed608090ddd0a6b036a2554765b8280e792356d43814ac33c4b8a03a4c91',
                'PreviousServerSeedSHA256' => '94c8db42acb323751db46e2af7308bc7493de6fe0f661c33cc0ca3cc8ab82b6f',
                'PreviousServerSeed' => '47SjWdGfrkQNshdm3bbTrdbX7hbSnulXGtLca6gT',
                'PreviousClientSeed' => 'XutvmnKehzZGuEfENwTTf1EleHDPBtfCQapGSIen',
                'BetData' => [
                    [
                        'id' => $kenoHistory->id,
                        'user_id' => $user->login,
                        'coinname' => $currency->name,
                        'time' => $kenoHistory->time_game,
                        'bet' => $bet,
                        'coeff' => $coeff,
                        'profit' => $winAmount,
                        'idc' => $idc,
                    ],
                ]
            ]
        ]);
    }

    private function randomNumbers($min, $max) {
        $rand = random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
        return sprintf("%0.0f", $rand);
    }

    public function getLastBets()
    {
        $history = KenoHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->name;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['idc'] = $result->currency->idc;
            $i++;
        }

        return response()->json([
            'd' => array_reverse($results)
        ]);
    }

    public function getAllLastBets()
    {
        $history = KenoHistory::query()->orderBy('id', 'desc')->limit(30)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->name;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['idc'] = $result->currency->idc;
            $i++;
        }

        return response()->json(array_reverse($results));
    }

    public function getRates()
    {
        $rates = KenoRate::query()->get();

        return response()->json($rates);
    }
}
