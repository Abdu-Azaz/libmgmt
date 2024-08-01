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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->index('book_title');            
            $table->string('isbn', 60)->nullable();
            $table->string('inventory_number', 100)->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('quantity');   
            $table->string('cover', 100)->nullable();
            $table->string('author', 100)->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
