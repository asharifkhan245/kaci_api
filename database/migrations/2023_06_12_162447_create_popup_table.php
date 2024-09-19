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
        Schema::create('popup', function (Blueprint $table) {
            $table->id();
            $table->enum('platform',['Android','IOS']);
            $table->string('title');
            $table->string('tag')->nullable();
            $table->string('image');
            $table->string('app_page');
            $table->enum('status',['ACTIVE','INACTIVE'])->default('INACTIVE');
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
        Schema::dropIfExists('popup');
    }
};
