<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKenoRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keno_rates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('number');
            $table->tinyInteger('count_win');
            $table->tinyInteger('type')->default(1);
            $table->float('coeff',10,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keno_rates');
    }
}
