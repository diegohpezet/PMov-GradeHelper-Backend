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
        Schema::create('attendances', function (Blueprint $table) {
            $table->foreignUuid('student_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('course_id')->constrained()->onDelete('cascade');
            $table->date('date');

            // Composite primary key: A student can only attend a course once per day
            $table->primary(['student_id', 'course_id', 'date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
