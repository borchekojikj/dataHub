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
        Schema::create('catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('catalogue_name');
            $table->string('catalogue_file_url');
            $table->string('catalogue_pic_url');
            $table->foreignId('store_id')->constrained('stores');
            $table->boolean('is_public')->default(false);
            $table->date('starting_period');
            $table->date('ending_period');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogues');
    }
};
