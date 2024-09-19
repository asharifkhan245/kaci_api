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
        Schema::create('ambulance', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('ksn');
            $table->string('reference_code');
            $table->longText('location');
            $table->longText('address');
            $table->string('ambulance_service');
            $table->string('people_involved');
            $table->string('incidence_nature');
            $table->longText('previous_hospital');
            $table->string('medication');
            $table->json('images');
            $table->string('name');
            $table->string('device');
            $table->string('admin');  
            $table->string('phone_number');
            $table->string('country');
            $table->enum('status',['Pending','Approved'])->default('Pending');
            $table->longText('response')->nullable();                                                                  
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
        Schema::dropIfExists('ambulance');
    }
};
