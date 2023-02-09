<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Game;
use App\Models\MineHistory;
use App\Models\MineRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MineService
{
    protected $game;

    protected $userStatisticService;

    public function __construct(UserStatisticService $userStatisticService)
    {
        $this->userStatisticService = $userStatisticService;
        $this->game = Game::where('name', 'Mines')->first();
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        $code = $request->get('code');
        $sum = (float) $request->get('sum');

        if (!$request->get('mines_count')) {
            return ['status' => 'error', 'message'  => 'need mines_count'];
        }

        if (!$sum) {
            return ['status' => 'error', 'message'  => 'need bet'];
        }

        $currency = Currency::where('code', $code)->first();

        $user->setActiveBalance($code);

        $count = $request->get('mines_count') ?? 2;

        if ($user->getActiveBalance() < $sum) {
            return ['status' => 'error', 'message'  => 'Не достаточно средств на счету'];
        }

        $mines = $this->generateMines($count);

        $game = new MineHistory();
        $game->user_id = $user->id;
        $game->currency_id = $currency->id;
        $game->sum = $sum;
        $game->count_mine = $count;
        $game->step = 0;
        $game->coeff = 1;
        $game->active = true;
        $game->mines = json_encode($mines);
        $game->remainder = $user->getActiveBalance();
        $game->time_game = Carbon::now();
        $game->save();

        $user->writeOffBalance($sum, $currency->accuracy);

        return [
            'balance' => $user->getActiveBalance(),
            'msg' => 'Игра началась!',
            'status' => 'success',
        ];
    }

    public function play(Request $request)
    {
        $cell = (int)$request->get('cell');
        $code = $request->get('code');
        if (!$cell) {
            return response()->json(['status' => 'error', 'message'  => 'need cell'], 400);
        }

        $user = Auth::user();
        $user->setActiveBalance($code);

        $mineGame = MineHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mineGame) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

        $currency = Currency::where('code', $code)->first();

        $mines = json_decode($mineGame->mines);
        $revealed = json_decode($mineGame->revealed);
        $revealed[] = $cell;

        $lose = in_array($cell, $mines) ? true : false;

        if ($lose) {
            $mineGame->active = false;
            $mineGame->lose = true;
            $mineGame->won_sum = 0;
            $mineGame->profit = -1 * $mineGame->sum;
        } else {
            ++$mineGame->step;
            $rate = MineRate::where(['mine' => $mineGame->count_mine, 'step' => $mineGame->step])->first();
            $mineGame->coeff = $rate ? $rate->coeff : $mineGame->coeff;
        }

        $mineGame->revealed = json_encode($revealed);

        $mineGame->save();

        if ($lose) {
            $result = [
                'active' => false,
                'coeff' => $mineGame->coeff,
                'lose' => $mineGame->lose,
                'mines' => json_decode($mineGame->mines),
                'revealed' => json_decode($mineGame->revealed),
                'status' => 'success',
                'step' => $mineGame->step,
                'sum' => $mineGame->sum,
                'possibleWin' => 0,
                'BetData' => [
                    [
                        'id' => $mineGame->id,
                        'user_id' => $user->login,
                        'coinname' => $mineGame->currency->name,
                        'time' => $mineGame->time_game,
                        'bet' => $mineGame->sum,
                        'count_mine' => $mineGame->count_mine,
                        'coeff' => $mineGame->coeff,
                        'profit' => $mineGame->profit,
                        'code' => $code,
                    ],
                ]
            ];

            $this->userStatisticService->setStatistic($user, $currency, $mineGame->sum, $mineGame->profit, $this->game->slug);

        } else {
            $result = [
                'active' => true,
                'coeff' => $mineGame->coeff,
                'lose' => $mineGame->lose,
                'mines' => [],
                'revealed' => json_decode($mineGame->revealed),
                'status' => 'success',
                'step' => $mineGame->step,
                'sum' => $mineGame->sum,
                'possibleWin' => $mineGame->sum * $mineGame->coeff,
            ];
        }

        return $result;
    }

    public function collect(Request $request)
    {
        $code = $request->get('code');
        $user = Auth::user();
        $mineGame = MineHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mineGame) {
            return ['status' => 'error', 'message'  => 'Game not found'];
        }

        $currency = Currency::where('code', $code)->first();

        $profit = $mineGame->sum * $mineGame->coeff;

        $user->setActiveBalance($code);
        $user->addToBalance($profit, $currency->accuracy);

        $mineGame->won_sum = $profit;
        $mineGame->active = false;
        $mineGame->profit = $profit;
        $mineGame->remainder = $user->getActiveBalance();
        $mineGame->save();

        $this->userStatisticService->setStatistic($user, $currency, $mineGame->sum, ($mineGame->profit - $mineGame->sum), $this->game->slug);

        return [
            'active' => $mineGame->active,
            'balance' => $user->getActiveBalance(),
            'coeff' => $mineGame->coeff,
            'lose' => $mineGame->lose,
            'mines' => json_decode($mineGame->mines),
            'revealed' => json_decode($mineGame->revealed),
            'status' => 'success',
            'step' => $mineGame->step,
            'won_sum' => $mineGame->won_sum,
            'BetData' => [
                [
                    'id' => $mineGame->id,
                    'user_id' => $user->login,
                    'coinname' => $mineGame->currency->name,
                    'time' => $mineGame->time_game,
                    'bet' => $mineGame->sum,
                    'count_mine' => $mineGame->count_mine,
                    'coeff' => $mineGame->coeff,
                    'profit' => $mineGame->profit,
                    'code' => $code,
                ],
            ]
        ];
    }

    private function generateMines($count = 3)
    {
        $arrayNumber = [];
        for ($i = 1; $i <= 25; $i++) {
            $arrayNumber[] = $i;
        }

        shuffle($arrayNumber);

        return array_rand(array_flip($arrayNumber), $count);
    }

    public function getLastBets()
    {
        $history = MineHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->name;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->sum;
            $results[$i]['count_mine'] = $result->count_mine;
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
        $history = MineHistory::query()->orderBy('id', 'desc')->limit(30)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->name;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->sum;
            $results[$i]['count_mine'] = $result->count_mine;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
            $i++;
        }

        return array_reverse($results);
    }

    public function getRates()
    {
        $rates = MineRate::select(['mine', 'step', 'coeff'])->get();
        $result = [];
        foreach ($rates as $rate) {
            $result[$rate->mine][] = [
                'step' => $rate->step,
                'coeff' => $rate->coeff,
            ];
        }

        return $result;
    }

    public function getGame()
    {
        return $this->game;
    }
}
