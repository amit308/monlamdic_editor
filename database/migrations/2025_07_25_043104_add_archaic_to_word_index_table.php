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
            if (!Schema::hasColumn('wordIndex', 'archaic')) {
                $table->boolean('archaic')->default(false)->after('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wordIndex', function (Blueprint $table) {
            if (Schema::hasColumn('wordIndex', 'archaic')) {
                $table->dropColumn('archaic');
            }
        });
    }
};
