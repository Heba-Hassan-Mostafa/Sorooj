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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_name');
            $table->string('slug')->unique();
            $table->longText('blog_content')->nullable();
            $table->string('author_name')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('brief_description');
            $table->date('publish_date');
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('order_position')->default(0);
            $table->string('keywords');
            $table->longtext('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};