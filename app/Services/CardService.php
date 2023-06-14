<?php

namespace App\Services;

use App\Models\CardHistory;
use App\Models\Currency;
use App\Models\Game;
use App\Models\MineHistory;
use App\Models\MineRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardService
{
    protected $game;

    protected $userStatisticService;

    public function __construct(UserStatisticService $userStatisticService)
    {
        $this->userStatisticService = $userStatisticService;
        $this->game = Game::where('name', 'Cards')->first();
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        $code = $request->get('code');
        $sum = (float) $request->get('sum');

        if (!$sum) {
            return ['status' => 'error', 'message'  => 'need bet'];
        }

        $currency = Currency::where('code', $code)->first();

        $user->setActiveBalance($code);

        if ($user->getActiveBalance() < $sum) {
            return ['status' => 'error', 'message'  => 'Не достаточно средств на счету'];
        }

        $cards = $this->generateCards($sum, $currency->accuracy);
        $minWon  = bcmul(StrHelperService::numberFormat($sum), StrHelperService::numberFormat(0.2), $currency->accuracy);
        $extraSum  = bcmul(StrHelperService::numberFormat($sum), StrHelperService::numberFormat(0.25), $currency->accuracy);

        $game = new CardHistory();
        $game->user_id = $user->id;
        $game->currency_id = $currency->id;
        $game->sum = $sum;
        $game->extra_sum = $extraSum;
        $game->min_won_sum = $minWon;
        $game->coeff = 1;
        $game->active = true;
        $game->revealed = json_encode([]);
        $game->cards = json_encode($cards);
        $game->remainder = $user->getActiveBalance();
        $game->time_game = Carbon::now();
        $game->save();

        $user->writeOffBalance($sum, $currency->accuracy);

        return [
            'balance' => $user->getActiveBalance(),
            'attempts' => $game->attempts,
            'msg' => 'Игра началась!',
            'status' => 'success',
        ];
    }

    public function play(Request $request)
    {
        $cell = (int)$request->get('cell');
        $code = $request->get('code');
        if (!$cell) {
            return response()->json(['status' => 'error', 'message'  => 'need cell'], 400);
        }

        $user = Auth::user();
        $user->setActiveBalance($code);

        $cardGame = CardHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$cardGame) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

        $currency = Currency::where('code', $code)->first();

        $cards = json_decode($cardGame->cards, true);
        $revealed = json_decode($cardGame->revealed, true);

        if (in_array($cell, $revealed)) {
            return ['status' => 'continue', 'message' => 'You have already chosen this card'];
        }

        if (count($revealed) >= 4) {
            return ['status' => 'error', 'message' => 'You lose'];
        }

        $revealed[] = $cell;

        $cellResult = $cards[$cell];

        $offerExtra = false;
        $lose = false;
        $win = false;
        $maxOpenCard = 0;

        if (count($revealed) <= $cardGame->attempts) {
            $res = [];
            foreach ($revealed as $value) {
                if (array_key_exists($cards[$value]['type'], $res)) {
                    $res[$cards[$value]['type']]++;
                } else {
                    $res[$cards[$value]['type']] = 1;
                }

                if ($res[$cards[$value]['type']] == 3) {
                    $win = true;
                    break;
                }
            }

            $maxOpenCard = count($res) ? max($res) : 0;
        }

        if (!$win && count($revealed) === 3 && $cardGame->attempts === 3) {
            $offerExtra = true;
        }

        if ($win) {
            $profit = StrHelperService::minus($cellResult['win'], $cardGame->sum, $currency->accuracy);
            if ($cardGame->is_extra) {
                $profit = StrHelperService::minus($profit, $cardGame->extra_sum, $currency->accuracy);
            }
            $cardGame->active = false;
            $cardGame->won_sum = $cellResult['win'];
            $cardGame->profit = $profit;

            $user->addToBalance($cardGame->won_sum, $currency->accuracy);
        }

        if (!$win && count($revealed) === $cardGame->attempts && $cardGame->is_extra) {
            $lose = true;
        }


        if ($lose) {
            $profit = StrHelperService::minus($cardGame->min_won_sum, $cardGame->sum, $currency->accuracy);
            if ($cardGame->is_extra) {
                $profit = StrHelperService::minus($profit, $cardGame->extra_sum, $currency->accuracy);
            }

            $cardGame->active = false;
            $cardGame->lose = true;
            $cardGame->won_sum = $cardGame->min_won_sum;
            $cardGame->profit = $profit;

            $user->addToBalance($cardGame->min_won_sum, $currency->accuracy);
        }

        $cardGame->revealed = json_encode($revealed);

        $cardGame->save();

        if ($lose) {
            $result = [
                'active' => false,
                'lose' => $cardGame->lose,
                'cards' => json_decode($cardGame->cards),
                'revealed' => json_decode($cardGame->revealed),
                'status' => 'success',
                'balance' => $user->getActiveBalance(),
                'sum' => $cardGame->sum,
                'won_sum' => $cardGame->won_sum,
                'BetData' => [
                    [
                        'id' => $cardGame->id,
                        'user_id' => $user->login,
                        'coinname' => $cardGame->currency->short_name,
                        'icon' => $currency->icon,
                        'time' => $cardGame->time_game,
                        'bet' => $cardGame->sum,
                        'count_mine' => $cardGame->count_mine,
                        'coeff' => $cardGame->coeff,
                        'profit' => $cardGame->profit,
                        'code' => $code,
                    ],
                ]
            ];

            $this->userStatisticService->setStatistic($user, $currency, $cardGame->sum, $cardGame->profit, $this->game->slug);

        } else {
            $result = [
                'win' => $win,
                'active' => $cardGame->active,
                'lose' => $cardGame->lose,
                'cards' => $win ? json_decode($cardGame->cards) : [],
                'revealed' => json_decode($cardGame->revealed),
                'status' => 'success',
                'attempts' => $cardGame->attempts,
                'sum' => $cardGame->sum,
                'extra_sum' => $cardGame->extra_sum,
                'min_won_sum' => $cardGame->min_won_sum,
                'cell_result' => $cellResult,
                'offer_extra' => $offerExtra,
                'max_open' => $maxOpenCard,
            ];

            if ($win) {
                $result['won_sum'] = $cardGame->won_sum;
                $result['BetData'] = [
                    [
                        'id' => $cardGame->id,
                        'user_id' => $user->login,
                        'coinname' => $cardGame->currency->short_name,
                        'icon' => $currency->icon,
                        'time' => $cardGame->time_game,
                        'bet' => $cardGame->sum,
                        'coeff' => $cardGame->coeff,
                        'profit' => $cardGame->profit,
                        'code' => $code,
                    ],
                ];
                $this->userStatisticService->setStatistic($user, $currency, $cardGame->sum, $cardGame->profit, $this->game->slug);
            }
        }

        return $result;
    }

    public function load(Request $request) {
        $user = Auth::user();

        $cardGame = CardHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if ($cardGame) {

            $cards = json_decode($cardGame->cards, true);
            $revealed = json_decode($cardGame->revealed, true);

            $offerExtra = false;
            $win = false;
            $maxOpenCard = 0;

            if (count($revealed) <= $cardGame->attempts) {
                $res = [];
                foreach ($revealed as $value) {
                    if (array_key_exists($cards[$value]['type'], $res)) {
                        $res[$cards[$value]['type']]++;
                    } else {
                        $res[$cards[$value]['type']] = 1;
                    }

                    if ($res[$cards[$value]['type']] == 3) {
                        $win = true;
                        break;
                    }
                }
                $maxOpenCard = count($res) ? max($res) : 0;
            }

            if (!$win && count($revealed) === 3 && $cardGame->attempts === 3 && !$cardGame->is_extra) {
                $offerExtra = true;
            }

            $openCards = [];
            foreach ($cards as $key => $card) {
                if (in_array($key, $revealed, true)) {
                    $openCards[$key] = $card;
                }
            }

            return [
                'win' => $win,
                'cards' => $openCards,
                'status' => 'success',
                'attempts' => $cardGame->attempts,
                'sum' => $cardGame->sum,
                'extra_sum' => $cardGame->extra_sum,
                'min_won_sum' => $cardGame->min_won_sum,
                'offer_extra' => $offerExtra,
                'max_open' => $maxOpenCard,
            ];
        }

        return [];
    }

    public function extraCard(Request $request) {
        $code = $request->get('code');

        $user = Auth::user();
        $user->setActiveBalance($code);

        $cardGame = CardHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$cardGame) {
            return ['status' => 'error', 'message' => 'Game not found'];
        }

        $currency = Currency::where('code', $code)->first();

        if (!$cardGame->is_extra) {
            $cardGame->is_extra = true;
            $cardGame->attempts++;

            if ($user->getActiveBalance() < $cardGame->extra_sum) {
                return ['status' => 'error', 'message'  => 'Не достаточно средств на счету'];
            }

            $user->writeOffBalance($cardGame->extra_sum, $currency->accuracy);

            $cardGame->remainder = StrHelperService::minus($cardGame->remainder, $cardGame->extra_sum, $currency->accuracy);

            $cardGame->save();

            return [
                'balance' => $user->getActiveBalance(),
                'attempts' =>  $cardGame->attempts,
                'msg' => 'Дополнительная карточка!',
                'status' => 'success',
            ];
        }
    }

    public function collect(Request $request)
    {
        $code = $request->get('code');
        $user = Auth::user();
        $cardGame = CardHistory::where(['user_id' => $user->id, 'active'=> true])->orderBy('id', 'DESC')->first();

        if (!$cardGame) {
            return ['status' => 'error', 'message'  => 'Game not found'];
        }

        $currency = Currency::where('code', $code)->first();

        $profit = StrHelperService::minus($cardGame->min_won_sum, $cardGame->sum, $currency->accuracy);

        $user->setActiveBalance($code);
        $user->addToBalance($cardGame->min_won_sum, $currency->accuracy);

        $cardGame->won_sum = $cardGame->min_won_sum;
        $cardGame->active = false;
        $cardGame->profit = $profit;
        $cardGame->remainder = $user->getActiveBalance();
        $cardGame->save();

        $this->userStatisticService->setStatistic($user, $currency, $cardGame->sum, $profit, $this->game->slug);

        return [
            'active' => $cardGame->active,
            'balance' => $user->getActiveBalance(),
            'lose' => $cardGame->lose,
            'cards' => json_decode($cardGame->cards),
            'revealed' => json_decode($cardGame->revealed),
            'status' => 'success',
            'won_sum' => $cardGame->won_sum,
            'BetData' => [
                [
                    'id' => $cardGame->id,
                    'user_id' => $user->login,
                    'coinname' => $currency->short_name,
                    'icon' => $currency->icon,
                    'time' => $cardGame->time_game,
                    'bet' => $cardGame->sum,
                    'coeff' => $cardGame->coeff,
                    'profit' => $cardGame->profit,
                    'code' => $code,
                ],
            ]
        ];
    }

    private function generateCards($bet, $accuracy = 8)
    {
        $min = StrHelperService::mul($bet, 2, $accuracy);
        $max = StrHelperService::mul($bet, 15, $accuracy);
        $maxWin = StrHelperService::minus($max, $min, $accuracy);

        $a1 = mt_rand(0,15);
        $a2 = mt_rand(25,45);
        $a3 = mt_rand(55,100);

        $cardOne = StrHelperService::mul($maxWin, $a1, $accuracy);
        $cardOne = StrHelperService::div($cardOne,100, $accuracy);
        $cardOne = StrHelperService::sum($cardOne, $min, $accuracy);

        $cardTwo = StrHelperService::mul($maxWin, $a2, $accuracy);
        $cardTwo = StrHelperService::div($cardTwo,100, $accuracy);
        $cardTwo = StrHelperService::sum($cardTwo, $min, $accuracy);

        $cardThree = StrHelperService::mul($maxWin, $a3, $accuracy);
        $cardThree = StrHelperService::div($cardThree,100, $accuracy);
        $cardThree = StrHelperService::sum($cardThree, $min, $accuracy);

        $arrayNumber = [];
        for ($i = 1; $i <= 3; $i++) {
            $arrayNumber[$i]['type'] = 1;
            $arrayNumber[$i]['win'] = $cardOne;
        }
        for ($i = 4; $i <= 6; $i++) {
            $arrayNumber[$i]['type'] = 2;
            $arrayNumber[$i]['win'] = $cardTwo;
        }
        for ($i = 7; $i <= 9; $i++) {
            $arrayNumber[$i]['type'] = 3;
            $arrayNumber[$i]['win'] = $cardThree;
        }

        shuffle($arrayNumber);
        $n = 1;
        $shuffledArray = [];
        foreach ($arrayNumber as $value) {
            $shuffledArray[$n] = $value;
            $n++;
        }

        return $shuffledArray;
    }

    public function getLastBets()
    {
        $history = MineHistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->short_name;
            $results[$i]['icon'] = $result->currency->icon;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->sum;
            $results[$i]['count_mine'] = $result->count_mine;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
            $i++;
        }

        return [
            'd' => array_reverse($results)
        ];
    }

    public function getAllLastBets()
    {
        $history = MineHistory::query()->orderBy('id', 'desc')->limit(30)->get();

        $results = [];
        $i = 0;
        foreach ($history as $result) {
            $results[$i]['id'] = $result->id;
            $results[$i]['user_id'] = $result->user->login;
            $results[$i]['coinname'] = $result->currency->short_name;
            $results[$i]['icon'] = $result->currency->icon;
            $results[$i]['time'] = $result->time_game;
            $results[$i]['bet'] = $result->sum;
            $results[$i]['count_mine'] = $result->count_mine;
            $results[$i]['coeff'] = $result->coeff;
            $results[$i]['profit'] = $result->profit;
            $results[$i]['code'] = $result->currency->code;
            $i++;
        }

        return array_reverse($results);
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

        return $result;
    }

    public function getGame()
    {
        return $this->game;
    }
}
