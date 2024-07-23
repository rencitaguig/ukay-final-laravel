<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('size');
            $table->text('description');
            $table->integer('quantity')->default(0);
            $table->integer('price');
            $table->longText('image')->nullable();
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('stock')->default(0);
            $table->softDeletes();
            $table->timestamps();  // Add this line
        });

        Schema::create('customer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_products');
        Schema::dropIfExists('products');
    }
};
