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
        Schema::create('beep', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->string('country');
            $table->string('location');
            $table->json('media');
            $table->bigInteger('like')->default(0);
            $table->bigInteger('comment')->default(0);
            $table->longText('description');
            $table->bigInteger('user_id');
            $table->enum('anonymous',['Yes','No'])->default('No');
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
        Schema::dropIfExists('beep');
    }
};
