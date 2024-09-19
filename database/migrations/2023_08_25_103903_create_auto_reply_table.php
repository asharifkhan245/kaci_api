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
        Schema::create('auto_reply', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('language');
            $table->longText('description');
            $table->enum('status',['Activated','Deactivated'])->default('Deactivated');
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
        Schema::dropIfExists('auto_reply');
    }
};
