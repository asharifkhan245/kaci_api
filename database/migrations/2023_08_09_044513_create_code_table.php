<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code', function (Blueprint $table) {
            $table->id();
            $table->string('amount')->nullable();
            $table->date('expire_date');
            $table->bigInteger('user_count');
            $table->bigInteger('request_day');
            $table->bigInteger('request_week');
            $table->bigInteger('request_monthly');
            $table->enum('status',['Active','InActive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code');
    }
};
