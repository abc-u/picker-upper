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
        Schema::create('tag_question', function (Blueprint $table) {
            $table->foreignId('questions_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('tags_id')->constrained('tags')->onDelete('cascade');
            $table->primary(['questions_id', 'tags_id']); // 複合キー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_question');
    }
};
