<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Models\DiceHistory;
use App\Services\DiceV2Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class DiceV2Controller
 */
class DiceV2Controller extends Controller
{
    /**
     * @var DiceV2Service
     */
    private $service;

    public function __construct(DiceV2Service $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, $currency)
    {
        $currency = Currency::where('idc', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $game = $this->service->getGame();

        return view('games.dice_v2.index', compact('currency', 'game'));
    }

    public function getBet(Request $request, $id)
    {
        $dice = DiceHistory::findOrFail($id);

        return view('games.dice.bet', compact('dice'));
    }

    public function getDiceResult(Request $request)
    {
        return response()->json($this->service->getDiceResult($request));
    }

    public function getLastBets()
    {
        return response()->json($this->service->getLastBets());
    }

    public function getAllLastBets()
    {
        return response()->json($this->service->getAllLastBets());
    }
}
