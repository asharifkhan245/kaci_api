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
        Schema::create('sos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('ksn');
            $table->string('reference_code');
            $table->json('images');
            $table->string('name');
            $table->string('device');
            $table->string('phone_number');
            $table->string('country');
            $table->enum('status',['Pending','Approved'])->default('Pending');
            $table->longText('response')->nullable();     
            $table->longText('map')->nullable();
            $table->longText('coordinate')->nullable();
            $table->string('location');
            $table->longtext('address');
            $table->longText('target_agency');
            $table->string('admin');
            $table->longText('comments');                   
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
        Schema::dropIfExists('sos');
    }
};
