<?php

use App\Enum\CategoryTypeEnum;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->enum('type',CategoryTypeEnum::values())->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('order_position')->default(0);
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
