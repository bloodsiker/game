<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Mine;
use App\Models\MineRate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MineController
 */
class MineController extends Controller
{

    public function create(Request $request)
    {
        $user = User::find(1);

        if (!$request->get('mines_count')) {
            return response()->json(['error' => 'need mines_count'], 400);
        }

        if (!$request->get('sum')) {
            return response()->json(['error' => 'need sum'], 400);
        }

        $count = $request->get('mines_count') ?? 2;
        $sum = $request->get('sum');

        if ($user->balance < $sum) {
            return response()->json(['error' => 'Не достаточно средст на счету'], 400);
        }

        $mines = $this->generateMines($count);

        $game = new Mine();
        $game->user_id = $user->id;
        $game->sum = $sum;
        $game->count_mine = $count;
        $game->step = 0;
        $game->coeff = 1;
        $game->active = true;
        $game->mines = json_encode($mines);
        $game->save();

        $user->balance -= $sum;
        $user->save();

        return response()->json([
            'balance' => 200,
            'msg' => 'Игра началась!',
            'status' => 'success',
        ]);
    }

    public function play(Request $request)
    {
        if (!$request->get('cell')) {
            return response()->json(['error' => 'need cell'], 400);
        }

        $mine = Mine::where(['user_id' => 1, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mine) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $cell = $request->get('cell');

        $mines = json_decode($mine->mines);
        $revealed = json_decode($mine->revealed);
        $revealed[] = $cell;

        $lose = in_array($cell, $mines) ? true : false;

        if ($lose) {
            $mine->active = false;
            $mine->lose = true;
            $mine->sum = 0;
        } else {
            ++$mine->step;
        }

        $rate = MineRate::where(['mine' => $mine->count_mine, 'step' => $mine->step])->first();

        $mine->coeff = $rate ? $rate->coeff : $mine->coeff;
        $mine->revealed = json_encode($revealed);

        $mine->save();

        if ($lose) {
            $result = [
                'active' => true,
                'coeff' => $mine->coeff,
                'lose' => $mine->lose,
                'mines' => [],
                'revealed' => json_decode($mine->revealed),
                'status' => 'success',
                'step' => $mine->step,
                'sum' => $mine->sum,
            ];
        } else {
            $result = [
                'active' => true,
                'coeff' => $mine->coeff,
                'lose' => $mine->lose,
                'mines' => [],
                'revealed' => json_decode($mine->revealed),
                'status' => 'success',
                'step' => $mine->step,
                'sum' => $mine->sum,
                'possibleWin' => $mine->sum * $mine->coeff,
            ];
        }


        return response()->json($result);
    }

    public function collect()
    {
        $mine = Mine::where(['user_id' => 1, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mine) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $mine->sum *= $mine->coeff;

        $user = User::find(1);
        $user->balance += $mine->sum;
        $user->save();

        $result = [
            'active' => false,
            'balance' => $user->balance,
            'coeff' => $mine->coeff,
            'lose' => $mine->lose,
            'mines' => json_decode($mine->mines),
            'revealed' => json_decode($mine->revealed),
            'status' => 'success',
            'step' => $mine->step,
            'won_sum' => $mine->sum,
        ];

        return response()->json($result);
    }

    private function generateMines($count = 3)
    {
        $arrayNumber = [];
        for ($i = 1; $i <= 25; $i++) {
            $arrayNumber[] = $i;
        }

        shuffle($arrayNumber);

        return array_rand($arrayNumber, $count);
    }

    public function rates(Request $request)
    {
        $count = $request->get('mines_count') ?? 2;

        $rates = MineRate::where('mine', $count)->get(['mine', 'step', 'coeff']);

        return response()->json([
            'status' => 200,
            'data' => $rates,
        ]);
    }
}
