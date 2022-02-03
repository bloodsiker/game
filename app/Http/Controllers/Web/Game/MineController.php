<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Models\Game;
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
}
