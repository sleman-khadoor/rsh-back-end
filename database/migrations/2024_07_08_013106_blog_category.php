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
        Schema::create('blog_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blogs');
            $table->foreignId('blog_category_id')->constrained('blog_categories');
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
