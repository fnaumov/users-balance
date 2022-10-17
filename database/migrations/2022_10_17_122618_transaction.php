<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->decimal('amount', 12, 4);
            $table->enum('currency', ['usd', 'eur', 'rub']);
            $table->enum('direction', ['in', 'out']);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->fullText('description');
            $table->index('direction');
            $table->index('created_at');
        });
    }

    public function down()
    {
        //
    }
};
