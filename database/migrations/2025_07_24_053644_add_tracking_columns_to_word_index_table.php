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
        Schema::table('wordIndex', function (Blueprint $table) {
            // Add user tracking columns
            $table->foreignId('created_by')->nullable();
            $table->foreignId('last_modified_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wordIndex', function (Blueprint $table) {
            // Drop tracking and timestamp columns
            $table->dropColumn([
                'created_by',
                'last_modified_by',
                'created_at',
                'updated_at'
            ]);
        });
    }
};
