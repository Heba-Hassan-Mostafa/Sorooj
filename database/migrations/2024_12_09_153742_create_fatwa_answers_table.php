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
        Schema::create('fatwa_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fatwa_question_id')->constrained()->cascadeOnDelete();
            $table->longText('answer_content')->nullable();
            $table->string('audio_file')->nullable();
            $table->string('youtube_link')->nullable();
            $table->date('publish_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fatwa_answers');
    }
};
