<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\CoinFlipRate;
use App\Models\Currency;
use App\Services\CoinFlipService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CoinFlipController
 */
class CoinFlipController extends Controller
{
    protected $service;

    public function __construct(CoinFlipService $service)
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
        $rates = CoinFlipRate::all();

        return view('games.coinflip.index', compact('currency', 'game', 'rates'));
    }

    public function create(Request $request)
    {
        return response()->json($this->service->start($request));
    }

    public function play(Request $request)
    {
        return response()->json($this->service->play($request));
    }

    public function collect(Request $request)
    {
        return response()->json($this->service->collect($request));
    }

    public function load(Request $request)
    {
        return response()->json($this->service->load($request));
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
