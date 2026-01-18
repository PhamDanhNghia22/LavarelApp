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
            $table->integerIncrements('id');
            $table->string('name',255);
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->string('image');
            $table->decimal('price',10,2);
            $table->integer('quantity');
            $table->integer('discount')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->longText('description')->nullable();
            $table->unsignedInteger('category_id')->unsigned();// unsigned không có dấu âm
            $table->unsignedInteger('brand_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->timestamps();
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
