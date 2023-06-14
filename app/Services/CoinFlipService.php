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

    protected $userStatisticService;

    public function __construct(UserStatisticService $userStatisticService)
    {
        $this->userStatisticService = $userStatisticService;
        $this->game = Game::where('name', 'Coin Flip')->first();
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        $code = $request->get('code');
        $bet = (float) $request->get('bet');

        if (!$bet) {
            return ['status' => 'error', 'message'  => 'need bet'];
        }

        $currency = Currency::where('code', $code)->first();

        $user->setActiveBalance($code);

        if ($user->getActiveBalance() < $bet) {
            return ['status' => 'error', 'message'  => 'Не достаточно средств на счету'];
        }

        $coins = $this->generateCoins();

        $user->writeOffBalance($bet, $currency->accuracy);

        $game = new CoinFlipHistory();
        $game->user_id = $user->id;
        $game->currency_id = $currency->id;
        $game->bet = $bet;
        $game->step = 0;
        $game->coeff = 0;
        $game->active = true;
        $game->remainder = $user->getActiveBalance();
        $game->coins = json_encode($coins);
        $game->revealed = json_encode([]);
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
        $code = $request->get('code');

        $user = Auth::user();
        $user->setActiveBalance($code);

        $coinGame = CoinFlipHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$coinGame) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

        $currency = Currency::where('code', $code)->first();

        $coins = json_decode($coinGame->coins);
        $revealed = json_decode($coinGame->revealed);
        $revealed[] = $coin;
        $coinGame->revealed = json_encode($revealed);

        $lose = !($coins[$coinGame->step] === $coin);
        $win = false;

        if ($lose) {
            $coinGame->active = false;
            $coinGame->lose = true;
            $coinGame->won_sum = 0;
            $coinGame->profit = StrHelperService::mul(-1, $coinGame->bet, $currency->accuracy);

            $this->userStatisticService->setStatistic($user, $currency, $coinGame->bet, $coinGame->profit, $this->game->slug);
        } else {
            ++$coinGame->step;
            $rate = CoinFlipRate::where(['step' => $coinGame->step])->first();
            if ($rate->finish) {
                $win = true;
            }

            $coinGame->coeff = $rate->coeff;
        }

        if ($win) {
            $profit = StrHelperService::mul($coinGame->bet, $coinGame->coeff, $currency->accuracy);

            $user->setActiveBalance($code);
            $user->addToBalance($profit, $currency->accuracy);

            $coinGame->won_sum = $profit;
            $coinGame->active = false;
            $coinGame->profit = $profit;
            $coinGame->remainder = $user->getActiveBalance();
            $coinGame->save();

            $this->userStatisticService->setStatistic($user, $currency, $coinGame->bet, ($profit - $coinGame->bet), $this->game->slug);
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
                'profit' => $coinGame->profit,
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
                        'code' => $code,
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
                'possibleWin' => (float) StrHelperService::mul($coinGame->bet, $coinGame->coeff, $currency->accuracy),
            ];

            if ($win) {
                $result['won_sum'] = (float) $coinGame->won_sum;
                $result['finish'] = 1;
                $result['BetData'] = [
                    [
                        'id' => $coinGame->id,
                        'user_id' => $user->login,
                        'coinname' => $coinGame->currency->name,
                        'time' => $coinGame->time_game,
                        'bet' => $coinGame->bet,
                        'coeff' => $coinGame->coeff,
                        'profit' => $coinGame->profit,
                        'code' => $code,
                    ],
                ];
            }
        }

        return $result;
    }

    public function load(Request $request) {
        $user = Auth::user();

        $coinGame = CoinFlipHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if ($coinGame) {
            $rate = CoinFlipRate::where(['step' => $coinGame->step])->select(['coeff', 'step'])->first();

            $revealed = json_decode($coinGame->revealed);

            return [
                'coeff' => $coinGame->coeff,
                'revealed' => $revealed,
                'status' => 'success',
                'step' => $coinGame->step,
                'bet' => $coinGame->bet,
                'finish' => $rate ? $rate->finish : null,
                'possibleWin' => $coinGame->bet * $coinGame->coeff,
            ];
        }

        return [];
    }

    public function collect(Request $request)
    {
        $code = $request->get('code');
        $user = Auth::user();
        $coinGame = CoinFlipHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$coinGame) {
            return response()->json(['status' => 'error', 'message'  => 'Game not found'], 404);
        }

        $currency = Currency::where('code', $code)->first();

        $profit = StrHelperService::mul($coinGame->bet, $coinGame->coeff, $currency->accuracy);

        $user->setActiveBalance($code);
        $user->addToBalance($profit, $currency->accuracy);

        $coinGame->won_sum = $profit;
        $coinGame->active = false;
        $coinGame->profit = $profit;
        $coinGame->remainder = $user->getActiveBalance();
        $coinGame->save();

        $this->userStatisticService->setStatistic($user, $currency, $coinGame->bet, ($profit - $coinGame->bet), $this->game->slug);

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
                    'coinname' => $coinGame->currency->short_name,
                    'icon' => $currency->icon,
                    'time' => $coinGame->time_game,
                    'bet' => $coinGame->bet,
                    'coeff' => $coinGame->coeff,
                    'profit' => $coinGame->profit,
                    'code' => $code,
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
            $results[$i]['coinname'] = $result->currency->short_name;
            $results[$i]['icon'] = $result->currency->icon;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
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
            $results[$i]['coinname'] = $result->currency->short_name;
            $results[$i]['icon'] = $result->currency->icon;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
            $i++;
        }

        return array_reverse($results);
    }

    public function getGame()
    {
        return $this->game;
    }
}
