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
        Schema::create('course_exercise', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('course_id');
            $table->foreignUuid('exercise_id');

            $table->timestamp('due_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_exercise');
    }
};
