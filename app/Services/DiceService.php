<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\DiceHistory;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiceService
{
    protected $game;

    protected $userStatisticService;

    public function __construct(UserStatisticService $userStatisticService)
    {
        $this->userStatisticService = $userStatisticService;
        $this->game = Game::where('name', 'Dice')->first();
    }

    public function getDiceResult(Request $request)
    {
        $user = Auth::user();
        $code = $request->get('code');
        $bet = (float)$request->get('bet');
        $multiplier = (float)$request->get('multiplier');
        $underOver = (int)$request->get('under_over');

        $currency = Currency::where('code', $code)->first();

        $user->setActiveBalance($code);


        $maxRatio = floor(((100 - $this->game->edge) / (100 * (0.010 / 100))));

        if ($multiplier > $maxRatio) {
            $error = 'Коэффициент выплат слишком велик. Максимальное соотношение: ' . $maxRatio;
        }

        if ($bet > $user->getActiveBalance()) {
            $error = 'Ставка больше вашего баланса.';
            return false;
        }

        $betMultiplier = bcmul(StrHelperService::numberFormat($bet), StrHelperService::numberFormat($multiplier), $currency->accuracy); // ($bet * $multiplier) - $bet
        $winAmount = bcsub($betMultiplier, StrHelperService::numberFormat($bet), $currency->accuracy);

        $chance = ((100.000 - $this->game->edge) / $multiplier);
        $chance = floor($chance * 1000) / 1000;

        $randRoll = (float)sprintf("%0.3f",  $this->randomFloat(0, 99.999));

        if ($underOver === 1) {
            $chance = 99.999 - $chance;
            if ($randRoll > $chance) {
                $user->addToBalance($winAmount, $currency->accuracy);
            } else {
                $winAmount = -1 * $bet;
                $user->writeOffBalance($bet, $currency->accuracy);
            }
        } elseif ($underOver === 2) {
            if ($randRoll < $chance) {
                $user->addToBalance($winAmount, $currency->accuracy);
            } else {
                $winAmount = -1 * $bet;
                $user->writeOffBalance($bet, $currency->accuracy);
            }
        }

        $explodeRoll = explode('.', (string) $randRoll);

        $first = str_split($explodeRoll[0]);
        $last = ['0', '0', '0'];
        if (count($first) === 1) {
            array_unshift($first, '0');
        }

        if (isset($explodeRoll[0], $explodeRoll[1])) {
            $last = str_split($explodeRoll[1]);
            if (count($last) === 0) {
                array_push($last, '0', '0', '0');
            } elseif (count($last) === 1) {
                array_push($last, '0', '0');
            } elseif (count($last) === 2) {
                $last[] = '0';
            }
        }

        $rollArray = array_merge($first, $last);

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

        $this->userStatisticService->setStatistic($user, $currency, $bet, $winAmount, $this->game->slug);

        return [
            'd' => [
                'roll' => $randRoll,
                'roll_array' => $rollArray,
                'bet' => $bet,
                'multiplier' => $multiplier,
                'under_over' => $underOver,
                'balance' => $user->getActiveBalance(),
                'win' => $winAmount,
                'code' => $code,
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
                        'coinname' => $currency->short_name,
                        'icon' => $currency->icon,
                        'time' => $diceHistory->time_game,
                        'bet' => $bet,
                        'multiplier' => $multiplier,
                        'target' => $diceHistory->target,
                        'roll' => $randRoll,
                        'profit' => $winAmount,
                        'code' => $code,
                        'accuracy' => $currency->accuracy,
                    ],
                ]
            ]
        ];
    }

//    private function randomFloat($min, $max) {
//        return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
//    }

    private function randomFloat($min = 0, $max = 1, $mul = 1000000)
    {
        return mt_rand($min * $mul, $max * $mul) / $mul;
    }

    public function getLastBets()
    {
        $diceHistory = DiceHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();

        $results = [];
        $i = 0;
        foreach ($diceHistory as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->short_name;
            $results[$i]['icon'] = $result->currency->icon;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['multiplier'] = $result->multiplier;
            $results[$i]['target'] = $result->target;
            $results[$i]['roll'] = $result->roll;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
            $results[$i]['accuracy'] = $result->currency->accuracy;
            $i++;
        }

        return [
            'd' => array_reverse($results)
        ];
    }

    public function getAllLastBets()
    {
        $diceHistory = DiceHistory::query()->orderBy('id', 'desc')->limit(50)->get();

        $results = [];
        $i = 0;
        foreach ($diceHistory as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->short_name;
            $results[$i]['icon'] = $result->currency->icon;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->bet;
            $results[$i]['multiplier'] = $result->multiplier;
            $results[$i]['target'] = $result->target;
            $results[$i]['roll'] = $result->roll;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
            $results[$i]['accuracy'] = $result->currency->accuracy;
            $i++;
        }

        return array_reverse($results);
    }

    public function getGame()
    {
        return $this->game;
    }
}
