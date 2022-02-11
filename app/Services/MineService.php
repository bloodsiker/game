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

    public function __construct()
    {
        $this->game = Game::where('name', 'Mines')->first();
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        $idc = $request->get('idc');
        $sum = (float) $request->get('sum');

        if (!$request->get('mines_count')) {
            return ['status' => 'error', 'message'  => 'need mines_count'];
        }

        if (!$sum) {
            return ['status' => 'error', 'message'  => 'need bet'];
        }

        $currency = Currency::where('idc', $idc)->first();

        $user->setActiveBalance($idc);

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

        $user->writeOffBalance($sum);

        return [
            'balance' => $user->getActiveBalance(),
            'msg' => 'Игра началась!',
            'status' => 'success',
        ];
    }

    public function play(Request $request)
    {
        $cell = (int)$request->get('cell');
        $idc = $request->get('idc');
        if (!$cell) {
            return response()->json(['status' => 'error', 'message'  => 'need cell'], 400);
        }

        $user = Auth::user();
        $user->setActiveBalance($idc);

        $mineGame = MineHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mineGame) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

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
                        'coeff' => $mineGame->coeff,
                        'profit' => $mineGame->profit,
                        'idc' => $idc,
                    ],
                ]
            ];
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
        $idc = $request->get('idc');
        $user = Auth::user();
        $mineGame = MineHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mineGame) {
            return ['status' => 'error', 'message'  => 'Game not found'];
        }

        $profit = $mineGame->sum * $mineGame->coeff;

        $user->setActiveBalance($idc);
        $user->addToBalance($mineGame->won_sum);

        $mineGame->won_sum = $profit;
        $mineGame->active = false;
        $mineGame->profit = $profit;
        $mineGame->remainder = $user->getActiveBalance();
        $mineGame->save();

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
                    'coeff' => $mineGame->coeff,
                    'profit' => $mineGame->profit,
                    'idc' => $idc,
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
        $history = MineHistory::query()->orderBy('id', 'desc')->limit(30)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->name;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->sum;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['idc'] = $result->currency->idc;
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