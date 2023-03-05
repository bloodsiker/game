<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\CardSetting;
use App\Models\Currency;
use App\Models\DiceHistory;
use App\Services\CardService;
use App\Services\DiceV2Service;
use App\Services\StrHelperService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CardController
 */
class CardController extends Controller
{
    /**
     * @var DiceV2Service
     */
    private $service;

    public function __construct(CardService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, $currency)
    {
        $currency = Currency::where('code', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $game = $this->service->getGame();
        $settings = CardSetting::where(['currency_id' => $currency->id])->first();

        return view('games.card.index', compact('currency', 'game', 'settings'));
    }

    public function create(Request $request)
    {
        return response()->json($this->service->start($request));
    }

    public function play(Request $request)
    {
        return response()->json($this->service->play($request));
    }

    public function extraCard(Request $request)
    {
        return response()->json($this->service->extraCard($request));
    }

    public function collect(Request $request)
    {
        return response()->json($this->service->collect($request));
    }

    public function load(Request $request)
    {
        return response()->json($this->service->load($request));
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
