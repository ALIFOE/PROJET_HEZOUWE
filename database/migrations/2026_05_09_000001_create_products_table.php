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
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->text('short');
            $table->longText('description');
            $table->string('image');
            $table->json('images')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('price_promo')->nullable();
            $table->unsignedSmallInteger('discount')->default(0);
            $table->string('badge')->nullable();
            $table->unsignedSmallInteger('stars')->default(5);
            $table->unsignedInteger('reviews')->default(0);
            $table->boolean('in_stock')->default(true);
            $table->json('details')->nullable();
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
