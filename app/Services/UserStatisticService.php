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
            $wagered = bcadd(StrHelperService::numberFormat($statistic->wagered), StrHelperService::numberFormat($bet), $currency->accuracy);
            $profit = bcadd(StrHelperService::numberFormat($statistic->profit), StrHelperService::numberFormat($profit), $currency->accuracy);
            $statistic->wagered = $wagered;
            $statistic->profit = $profit;
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
