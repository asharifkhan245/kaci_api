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
        Schema::create('kaci_code', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->bigInteger('user_count');
            $table->date('expiry_date');
            $table->enum('status',['Active','InActive']);
            $table->bigInteger('request_day');
            $table->bigInteger('request_week');
            $table->bigInteger('request_monthly');
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('kaci_code');
    }
};
