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
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('audio_file')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('brief_description')->nullable();
            $table->boolean('status')->default(1);
            $table->date('publish_date');
            $table->unsignedBigInteger('order_position')->default(0);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->string('keywords')->nullable();
            $table->longtext('description')->nullable();
            $table->unsignedBigInteger('audioable_id')->nullable();
            $table->string('audioable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audios');
    }
};
