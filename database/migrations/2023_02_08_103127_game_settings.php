<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GameSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dice_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->double('edge');
            $table->double('max_win', 19, 8);
            $table->double('min_bid', 10, 8);
            $table->double('min_ratio', 4, 4);

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dice_settings');
    }
}
