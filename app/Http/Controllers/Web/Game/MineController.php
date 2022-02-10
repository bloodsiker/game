<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Models\Game;
use App\Models\MineHistory;
use App\Models\MineRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class MineController
 */
class MineController extends Controller
{
    protected $game;

    public function __construct()
    {
        $this->game = Game::where('name', 'Mines')->first();
    }

    public function index(Request $request, $currency)
    {
        $currency = Currency::where('idc', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $game = $this->game;

        return view('games.mine.index', compact('currency', 'game'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $idc = $request->get('idc');
        $sum = (float) $request->get('sum');

        if (!$request->get('mines_count')) {
            return response()->json(['status' => 'error', 'message'  => 'need mines_count'], 400);
        }

        if (!$sum) {
            return response()->json(['status' => 'error', 'message'  => 'need bet'], 400);
        }

        $currency = Currency::where('idc', $idc)->first();

        $user->setActiveBalance($idc);

        $count = $request->get('mines_count') ?? 2;

        if ($user->getActiveBalance() < $sum) {
            return response()->json(['status' => 'error', 'message'  => 'Не достаточно средств на счету'], 400);
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
        $game->time_game = Carbon::now();
        $game->save();

        $user->writeOffBalance($sum);

        return response()->json([
            'balance' => $user->getActiveBalance(),
            'msg' => 'Игра началась!',
            'status' => 'success',
        ]);
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
            return response()->json(['status' => 'error', 'message' => 'Game not found'], 404);
        }

        $mines = json_decode($mineGame->mines);
        $revealed = json_decode($mineGame->revealed);
        $revealed[] = $cell;

        $lose = in_array($cell, $mines) ? true : false;

        if ($lose) {
            $mineGame->active = false;
            $mineGame->lose = true;
            $mineGame->won_sum = 0;
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

        return response()->json($result);
    }

    public function collect(Request $request)
    {
        $idc = $request->get('idc');
        $user = Auth::user();
        $mineGame = MineHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$mineGame) {
            return response()->json(['status' => 'error', 'message'  => 'Game not found'], 404);
        }

        $mineGame->won_sum = $mineGame->sum * $mineGame->coeff;
        $mineGame->active = false;
        $mineGame->save();

        $user->setActiveBalance($idc);
        $user->addToBalance($mineGame->won_sum);

        $result = [
            'active' => $mineGame->active,
            'balance' => $user->getActiveBalance(),
            'coeff' => $mineGame->coeff,
            'lose' => $mineGame->lose,
            'mines' => json_decode($mineGame->mines),
            'revealed' => json_decode($mineGame->revealed),
            'status' => 'success',
            'step' => $mineGame->step,
            'won_sum' => $mineGame->won_sum,
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

        return array_rand(array_flip($arrayNumber), $count);
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

        return response()->json($result);
    }
}
