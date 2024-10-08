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
        // Remove foreign keys from grades table
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['exercise_id']);
        });
        
        // Helper function to rename columns
        $renameColumns = function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change(); 
            $table->renameColumn('id', 'temp_id');
            $table->dropPrimary(['temp_id']);
            $table->renameColumn('uuid', 'id');
            $table->primary('id'); 
            $table->dropColumn('temp_id'); 
        };

        Schema::table('users', $renameColumns);
        Schema::table('exercises', $renameColumns);
        Schema::table('courses', $renameColumns);
        Schema::table('grades', $renameColumns);

        // Add foreign keys to grades table
        Schema::table('grades', function (Blueprint $table) {
            $table->uuid('student_id')->change();
            $table->uuid('exercise_id')->change();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });

        // Personal access tokens
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('tokenable_id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse changes to 'users', 'exercises', and 'courses'
        $reverseColumns = function (Blueprint $table) {
            $table->renameColumn('id', 'uuid');
            $table->dropPrimary(['uuid']);
            $table->bigIncrements('id')->first();
        };

        Schema::table('users', $reverseColumns);
        Schema::table('exercises', $reverseColumns);
        Schema::table('courses', $reverseColumns);
        Schema::table('grades', $reverseColumns);

        // Remove foreign keys from 'grades' table again before reversing the changes
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['exercise_id']);
            $table->unsignedBigInteger('student_id')->change();
            $table->unsignedBigInteger('exercise_id')->change();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });

        // Reverse changes to 'personal_access_tokens'
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->integer('tokenable_id')->change(); // Change back to the original type if necessary
        });
    }
};
