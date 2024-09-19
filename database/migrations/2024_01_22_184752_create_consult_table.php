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
        Schema::create('consult', function (Blueprint $table) {
            $table->id();
$table->string('location');
$table->integer('user_id');
            $table->bigInteger('ksn');
            $table->string('reference_code');
            $table->json('images');
            $table->string('target_agency');
            $table->longText('subject');
            $table->longText('descripiton');
            $table->enum('anonymous',['Yes','No'])->default('No');
            $table->enum('status',['Pending','Approved'])->default('Pending');
            $table->longText('response')->nullable();
            $table->string('admin');
            $table->string('device');
            $table->string('phone_number');
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
        Schema::dropIfExists('consult');
    }
};
