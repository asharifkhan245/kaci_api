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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->longText('logo');
            $table->string('title');
            $table->string('country');
            $table->string('website');
            $table->string('contact_number');
            $table->enum('featured',['YES','NO'])->default('NO');
            $table->longText('address');
            $table->string("head_email1");
            $table->string('head_email2');
            $table->string('head_contact_number');
            $table->string('multi_email1');
            $table->string('multi_email2');
            $table->string('multi_contact_number');
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
        Schema::dropIfExists('agencies');
    }
};
