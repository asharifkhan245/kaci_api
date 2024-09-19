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
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('ksn');
            $table->string('reference_code');
            $table->json('images');
            $table->string('name');
            $table->string('device');
            $table->string('admin');  
            $table->string('phone_number');
            $table->string('country');
            $table->enum('status',['Pending','Approved'])->default('Pending');
            $table->longText('response')->nullable();                           
            $table->string('boarding');
            $table->string('destination');
            $table->string('vehicle_type');
            $table->string('vehicle_detail');
            $table->string('trip_duration');
            $table->string('additional_info');
            $table->string('email');
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
        Schema::dropIfExists('travel');
    }
};
