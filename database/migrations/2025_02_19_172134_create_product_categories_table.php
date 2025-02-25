<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('count')->nullable();
            $table->json('image')->nullable(); // Store image as JSON
            $table->string('icon')->nullable(); // Store icon as a string (e.g., FontAwesome class)
            $table->string('color')->nullable(); // Store color as a hex code
            $table->enum('type', ['category', 'location', 'feature'])->default('category');
            $table->boolean('has_child')->default(false);
            $table->string('category_image')->nullable(); // URL or path to the category image
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
