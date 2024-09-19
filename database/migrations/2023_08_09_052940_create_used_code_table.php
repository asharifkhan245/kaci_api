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
        Schema::create('used_code', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('code');
            $table->bigInteger('code_id');
            $table->date('expiry_date');
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
        Schema::dropIfExists('used_code');
    }
};
