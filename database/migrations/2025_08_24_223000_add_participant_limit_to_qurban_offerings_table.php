<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('qurban_offerings', function (Blueprint $table) {
            $table->unsignedInteger('participant_limit')->nullable()->after('price');
        });
    }

    public function down()
    {
        Schema::table('qurban_offerings', function (Blueprint $table) {
            $table->dropColumn('participant_limit');
        });
    }
};
