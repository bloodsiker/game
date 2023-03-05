<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\User;
use App\Models\UserStatistic;

class UserStatisticService
{

    public function setStatistic(User $user, Currency $currency, $bet, $profit, $game)
    {
        $statistic = UserStatistic::where(['user_id' => $user->id, 'currency_id' => $currency->id])->first();
        if ($statistic) {
            ++$statistic->{$game};
            $statistic->wagered = StrHelperService::sum($statistic->wagered, $bet, $currency->accuracy);
            $statistic->profit = StrHelperService::sum($statistic->profit, $profit, $currency->accuracy);
            $statistic->save();
        } else {
            UserStatistic::create([
                'user_id' => $user->id,
                'currency_id' => $currency->id,
                'wagered' => $bet,
                'profit' => $profit,
                $game => 1,
            ]);
        }
    }
}
