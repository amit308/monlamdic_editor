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
            if (!Schema::hasColumn('wordIndex', 'pending')) {
                $table->boolean('pending')->default(false)->after('newword');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wordIndex', function (Blueprint $table) {
            if (Schema::hasColumn('wordIndex', 'pending')) {
                $table->dropColumn('pending');
            }
        });
    }
};
