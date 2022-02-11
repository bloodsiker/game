<?php

namespace App\Services;

use App\Models\CoinFlipHistory;
use App\Models\CoinFlipRate;
use App\Models\Currency;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoinFlipService
{
    protected $game;

    public function __construct()
    {
        $this->game = Game::where('name', 'Coin Flip')->first();
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        $idc = $request->get('idc');
        $bet = (float) $request->get('bet');

        if (!$bet) {
            return ['status' => 'error', 'message'  => 'need bet'];
        }

        $currency = Currency::where('idc', $idc)->first();

        $user->setActiveBalance($idc);

        if ($user->getActiveBalance() < $bet) {
            return ['status' => 'error', 'message'  => 'Не достаточно средств на счету'];
        }

        $coins = $this->generateCoins();

        $user->writeOffBalance($bet);

        $game = new CoinFlipHistory();
        $game->user_id = $user->id;
        $game->currency_id = $currency->id;
        $game->bet = $bet;
        $game->step = 0;
        $game->coeff = 0;
        $game->active = true;
        $game->remainder = $user->getActiveBalance();
        $game->coins = json_encode($coins);
        $game->time_game = Carbon::now();
        $game->save();

        return [
            'balance' => $user->getActiveBalance(),
            'msg' => 'Игра началась!',
            'status' => 'success',
        ];
    }

    public function play(Request $request)
    {
        $coin = (int)$request->get('coin');
        $idc = $request->get('idc');

        $user = Auth::user();
        $user->setActiveBalance($idc);

        $coinGame = CoinFlipHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$coinGame) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

        $coins = json_decode($coinGame->coins);
        $revealed = json_decode($coinGame->revealed);
        $revealed[] = $coin;
        $coinGame->revealed = json_encode($revealed);

        $lose = !($coins[$coinGame->step] === $coin);

        if ($lose) {
            $coinGame->active = false;
            $coinGame->lose = true;
            $coinGame->won_sum = 0;
            $coinGame->profit = -1 * $coinGame->bet;
        } else {
            ++$coinGame->step;
            $rate = CoinFlipRate::where(['step' => $coinGame->step])->first();
            $coinGame->coeff = $rate ? $rate->coeff : $coinGame->coeff;
        }

        $coinGame->save();

        if ($lose) {
            $result = [
                'active' => false,
                'coeff' => $coinGame->coeff,
                'lose' => $coinGame->lose,
                'coins' => json_decode($coinGame->coins),
                'revealed' => json_decode($coinGame->revealed),
                'status' => 'success',
                'step' => $coinGame->step,
                'bet' => $coinGame->bet,
                'coin' => $coins[$coinGame->step],
                'profit' => -1 * $coinGame->bet,
                'finish' => 0,
                'possibleWin' => 0,
                'BetData' => [
                    [
                        'id' => $coinGame->id,
                        'user_id' => $user->login,
                        'coinname' => $coinGame->currency->name,
                        'time' => $coinGame->time_game,
                        'bet' => $coinGame->bet,
                        'coeff' => $coinGame->coeff,
                        'profit' => $coinGame->profit,
                        'idc' => $idc,
                    ],
                ],
            ];
        } else {
            $result = [
                'active' => true,
                'coeff' => $coinGame->coeff,
                'lose' => $coinGame->lose,
                'coins' => [],
                'revealed' => json_decode($coinGame->revealed),
                'status' => 'success',
                'step' => $coinGame->step,
                'bet' => $coinGame->bet,
                'coin' => $coins[$coinGame->step - 1],
                'finish' => $rate->finish,
                'possibleWin' => $coinGame->bet * $coinGame->coeff,
            ];
        }

        return $result;
    }

    public function collect(Request $request)
    {
        $idc = $request->get('idc');
        $user = Auth::user();
        $coinGame = CoinFlipHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$coinGame) {
            return response()->json(['status' => 'error', 'message'  => 'Game not found'], 404);
        }

        $profit = $coinGame->bet * $coinGame->coeff;

        $user->setActiveBalance($idc);
        $user->addToBalance($coinGame->won_sum);

        $coinGame->won_sum = $profit;
        $coinGame->active = false;
        $coinGame->profit = $profit;
        $coinGame->remainder = $user->getActiveBalance();
        $coinGame->save();

        return [
            'active' => $coinGame->active,
            'balance' => $user->getActiveBalance(),
            'coeff' => $coinGame->coeff,
            'lose' => $coinGame->lose,
            'coins' => json_decode($coinGame->coins),
            'revealed' => json_decode($coinGame->revealed),
            'remainder' => $user->getActiveBalance(),
            'status' => 'success',
            'step' => $coinGame->step,
            'profit' => $coinGame->won_sum,
            'won_sum' => $coinGame->won_sum,
            'BetData' => [
                [
                    'id' => $coinGame->id,
                    'user_id' => $user->login,
                    'coinname' => $coinGame->currency->name,
                    'time' => $coinGame->time_game,
                    'bet' => $coinGame->bet,
                    'coeff' => $coinGame->coeff,
                    'profit' => $coinGame->profit,
                    'idc' => $idc,
                ],
            ]
        ];
    }

    private function generateCoins()
    {
        $arrayNumber = [];
        for ($i = 1; $i <= 10; $i++) {
            $arrayNumber[] = random_int(0, 1);
        }

        shuffle($arrayNumber);

        return $arrayNumber;
    }

    public function getLastBets()
    {
        $history = CoinFlipHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();

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

        return [
            'd' => array_reverse($results)
        ];
    }

    public function getAllLastBets()
    {
        $history = CoinFlipHistory::query()->orderBy('id', 'desc')->limit(30)->get();

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

        return array_reverse($results);
    }

    public function getGame()
    {
        return $this->game;
    }
}
