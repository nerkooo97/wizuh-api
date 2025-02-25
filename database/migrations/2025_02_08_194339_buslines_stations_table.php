<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buslines_stations', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('busline_id');
            $table->integer('city_id');
            $table->dateTime('time');
            $table->integer('fetured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
