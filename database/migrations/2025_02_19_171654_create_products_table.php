<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('title');
            $table->json('image'); // Store image as JSON
            $table->string('video_url')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('create_date');
            $table->string('date_establish')->nullable();
            $table->double('rate')->default(0.0);
            $table->integer('num_rate')->default(0);
            $table->string('rate_text')->nullable();
            $table->string('status')->nullable();
            $table->boolean('favorite')->default(false);
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->json('tags')->nullable(); // Store tags as JSON
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('author_id')->nullable()->constrained('users');
            $table->json('galleries')->nullable(); // Store galleries as JSON
            $table->json('features')->nullable(); // Store features as JSON
            $table->json('related')->nullable(); // Store related products as JSON
            $table->json('latest')->nullable(); // Store latest products as JSON
            $table->json('open_hours')->nullable(); // Store open hours as JSON
            $table->json('socials')->nullable(); // Store socials as JSON
            $table->json('attachments')->nullable(); // Store attachments as JSON
            $table->json('gps')->nullable(); // Store GPS as JSON
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
