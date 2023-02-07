<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Services\KenoService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class KenoController
 */
class KenoController extends Controller
{
    /**
     * @var KenoService
     */
    private $service;

    public function __construct(KenoService $service)
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

        return view('games.keno.index', compact('currency', 'game'));
    }

    public function getKenoResult(Request $request)
    {
        return response()->json($this->service->getKenoResult($request));
    }

    public function getLastBets()
    {
        return response()->json($this->service->getLastBets());
    }

    public function getAllLastBets()
    {
        return response()->json($this->service->getAllLastBets());
    }

    public function getRates()
    {
        return response()->json($this->service->getRates());
    }
}
