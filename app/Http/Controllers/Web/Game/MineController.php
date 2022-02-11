<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Services\MineService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MineController
 */
class MineController extends Controller
{
    /**
     * @var MineService
     */
    private $service;

    public function __construct(MineService $service)
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

        return view('games.mine.index', compact('currency', 'game'));
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

    public function getRates()
    {
        return response()->json($this->service->getRates());
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
