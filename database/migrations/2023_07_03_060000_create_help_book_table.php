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
        Schema::create('help_book', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('logo');
            $table->longText('description');
$table->string('country');
$table->string('contact_number');
$table->string('website_email');
$table->longText('address');
$table->json('images');
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
        Schema::dropIfExists('help_book');
    }
};
