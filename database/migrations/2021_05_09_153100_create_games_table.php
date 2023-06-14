<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->double('edge');
            $table->double('max_win');
            $table->double('min_bid');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('code');
            $table->integer('accuracy')->default(8);
            $table->string('icon', 255);
            $table->boolean('is_active')->default(1);
            $table->integer('position')->default(1);
            $table->timestamps();
        });

        $games = [
            [
                'name' => 'Dice',
                'slug' => 'dice',
                'edge' => 1,
                'max_win' => 50000,
                'min_bid' => 0.1,
            ],
            [
                'name' => 'Mines',
                'slug' => 'mines',
                'edge' => 1,
                'max_win' => 50000,
                'min_bid' => 0.1,
            ],
            [
                'name' => 'Keno',
                'slug' => 'keno',
                'edge' => 1,
                'max_win' => 50000,
                'min_bid' => 0.1,
            ],
            [
                'name' => 'Coin Flip',
                'slug' => 'coin_flip',
                'edge' => 1,
                'max_win' => 50000,
                'min_bid' => 0.1,
            ],
            [
                'name' => 'Cards',
                'slug' => 'cards',
                'edge' => 1,
                'max_win' => 50000,
                'min_bid' => 0.1,
            ],
            [
                'name' => 'Dicev2',
                'slug' => 'dicev2',
                'edge' => 1,
                'max_win' => 50000,
                'min_bid' => 0.1,
            ],
        ];

        foreach ($games as $game) {
            \App\Models\Game::create($game);
        }

        $currencies = [
            [
                'name' => 'Bitcoin',
                'short_name' => 'BTC',
                'code' => 'btc',
                'accuracy' => 8,
                'icon' => '/assets/coins/btc.png',
                'position' => 1,
            ],
            [
                'name' => 'Litecoin',
                'short_name' => 'LTC',
                'code' => 'ltc',
                'accuracy' => 8,
                'icon' => '/assets/coins/ltc.png',
                'position' => 2,
            ],
            [
                'name' => 'ETHEREUMCLASSIC',
                'short_name' => 'ETC',
                'code' => 'etc',
                'accuracy' => 8,
                'icon' => '/assets/coins/etc.png',
                'position' => 3,
            ],
        ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::create($currency);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('games');
    }
}
