<?php

namespace App\Http\Controllers\Web\Game;

use App\Models\Currency;
use App\Models\DiceHistory;
use App\Models\Game;
use App\Models\Mine;
use App\Models\MineRate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class DiceController
 */
class DiceController extends Controller
{
    protected $game;

    public function __construct()
    {
        $this->game = Game::where('name', 'Dice')->first();
    }

    public function index(Request $request, $currency)
    {
        $currency = Currency::where('idc', $currency)->first();
        if (!$currency) {
            abort(404);
        }

        $game = $this->game;

        return view('games.dice.index', compact('currency', 'game'));
    }

    public function getBet(Request $request, $id)
    {
        $dice = DiceHistory::findOrFail($id);

        return view('games.dice.bet', compact('dice'));
    }

    public function getDiceResult(Request $request)
    {
        $user = Auth::user();
        $idc = $request->get('idc');
        $bet = (float)$request->get('bet');
        $multiplier = (float)$request->get('multiplier');
        $underOver = (int)$request->get('under_over');
        $clientseed = $request->get('clientseed');

        $currency = Currency::where('idc', $idc)->first();

        $user->setActiveBalance($idc);


        $maxRatio = floor(((100 - $this->game->edge) / (100 * (0.010 / 100))));

        if ($multiplier > $maxRatio) {
            $error = 'Коэффициент выплат слишком велик. Максимальное соотношение: ' . $maxRatio;
        }

        if ($bet > $user->getActiveBalance()) {
            $error = 'Ставка больше вашего баланса.';
            return false;
        }

        $winAmount = ($bet * $multiplier) - $bet;
        $winAmount = (float)sprintf("%0.2f",  $winAmount);

        $chance = ((100.000 - $this->game->edge) / $multiplier);
        $chance = floor($chance * 1000) / 1000;

        $randRoll = (float)sprintf("%0.3f",  $this->randomFloat(0, 99.999));

        if ($underOver === 1) {
            $chance = 99.999 - $chance;
            if ($randRoll > $chance) {
                $user->addToBalance($winAmount);
            } else {
                $winAmount = -1 * $bet;
                $user->writeOffBalance($bet);
            }
        } elseif ($underOver === 2) {
            if ($randRoll < $chance) {
                $user->addToBalance($winAmount);
            } else {
                $winAmount = -1 * $bet;
                $user->writeOffBalance($bet);
            }
        }

        $diceHistory = DiceHistory::create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'under_over' => $underOver,
            'bet' => $bet,
            'profit' => $winAmount,
            'multiplier' => $multiplier,
            'roll' => $randRoll,
            'remainder' => $user->getActiveBalance(),
            'target' => $underOver === 1 ? '> ' . $chance : ' < ' . $chance,
            'time_game' => Carbon::now(),
        ]);

        return response()->json([
            'd' => [
                'roll' => $randRoll,
                'bet' => $bet,
                'multiplier' => $multiplier,
                'under_over' => $underOver,
                'balance' => $user->getActiveBalance(),
                'win' => $winAmount,
                'idc' => $idc,
                'longid' => null,
                'comment' => null,
                'client_seed' => null,
                'result' => true,
                'id' => $diceHistory->id,
                'NextServerSeedSHA256' => 'c8c7ed608090ddd0a6b036a2554765b8280e792356d43814ac33c4b8a03a4c91',
                'PreviousServerSeedSHA256' => '94c8db42acb323751db46e2af7308bc7493de6fe0f661c33cc0ca3cc8ab82b6f',
                'PreviousServerSeed' => '47SjWdGfrkQNshdm3bbTrdbX7hbSnulXGtLca6gT',
                'PreviousClientSeed' => 'XutvmnKehzZGuEfENwTTf1EleHDPBtfCQapGSIen',
                'BetData' => [
                    [
                        'id' => $diceHistory->id,
                        'user_id' => $user->login,
                        'coinname' => $currency->name,
                        'time' => $diceHistory->time_game,
                        'bet' => $bet,
                        'multiplier' => $multiplier,
                        'target' => $diceHistory->target,
                        'roll' => $randRoll,
                        'profit' => $winAmount,
                        'idc' => $idc,
                    ],
                ]
            ]
        ]);
    }

    private function randomFloat($min, $max) {
        return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
    }

    public function getLastBets()
    {
        $diceHistory = DiceHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();

        $results = [];
        $i = 0;
        foreach ($diceHistory as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->name;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['multiplier'] = $result->multiplier;
            $results[$i]['target'] = $result->target;
            $results[$i]['roll'] = $result->roll;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['idc'] = $result->currency->idc;
            $i++;
        }

        return response()->json([
            'd' => array_reverse($results)
        ]);
    }
}
