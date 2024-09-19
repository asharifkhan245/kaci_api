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
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('flag_code');
            $table->string('country_code');
            $table->string('emergency_number');
            $table->string('local_number');
            $table->string('gcare_email');
            $table->string('admin_email');
            $table->enum('featured',['YES','NO'])->default('NO');
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
        Schema::dropIfExists('country');
    }
};
