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
        Schema::create('qurban_offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qurban_event_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['goat', 'cow_share']);
            $table->string('name', 100);
            $table->unsignedInteger('price');
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
        Schema::dropIfExists('qurban_offerings');
    }
};