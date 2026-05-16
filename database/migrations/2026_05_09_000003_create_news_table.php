<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->json('tag')->nullable();
            $table->string('author');
            $table->date('date');
            $table->text('excerpt');
            $table->longText('intro');
            $table->json('body')->nullable();
            $table->longText('quote')->nullable();
            $table->longText('conclusion')->nullable();
            $table->string('read', 20)->default('1 min');
            $table->unsignedInteger('comments')->default(0);
            $table->string('image');
            $table->string('thumb')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
