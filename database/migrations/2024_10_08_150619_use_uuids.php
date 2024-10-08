<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['users', 'courses', 'exercises', 'grades'];
        
        foreach ($tables as $table) {
            // Add uuid column
            Schema::table($table, function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->after('id');
            });

            // Fill uuid column
            DB::table($table)->get()->each(function ($item) use ($table) {
                DB::table($table)->where('id', $item->id)->update(['uuid' => (string) Str::uuid()]);
            });

            // Prevent from being null and repeated when creating new records
            Schema::table($table, function (Blueprint $table) {
                $table->uuid('uuid')->nullable(false)->unique()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['users', 'courses', 'exercises'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
};
