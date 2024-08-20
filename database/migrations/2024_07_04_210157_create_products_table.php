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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->foreignId('store_id')->constrained('stores');
            $table->integer('regular_price');
            $table->integer('discounted_price');
            $table->foreignId('manufacturer_id')->constrained('manufacturers');
            $table->string('product_url');
            $table->integer('discount_percentage');
            $table->string('image_url');
            $table->boolean('in_stock');
            $table->string('product_code');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
            $table->string('category_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
