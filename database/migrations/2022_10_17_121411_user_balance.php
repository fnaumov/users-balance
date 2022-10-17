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
            $table->decimal('balance', 12, 4);
            $table->enum('currency', ['usd', 'eur', 'rub']);
            $table->timestamps();

            $table->unique(['user_id', 'currency']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        //
    }
};
