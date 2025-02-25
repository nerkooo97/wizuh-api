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
        Schema::create('buslines', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('city_start');
            $table->string('city_end');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->json('days_in_week');
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
