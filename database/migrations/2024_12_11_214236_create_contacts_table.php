<?php

use App\Enum\ContactStatusEnum;
use App\Enum\ContactTypeEnum;
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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->text('message');
            $table->text('reply')->nullable();
            $table->enum('type',ContactTypeEnum::values());
            $table->enum('status',ContactStatusEnum::values())->default(ContactStatusEnum::UNANSWERED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
