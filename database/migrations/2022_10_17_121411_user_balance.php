<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_balances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->unsignedDecimal('balance', 8, 4);
            $table->enum('currency', ['usd', 'eur', 'rub']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        //
    }
};
