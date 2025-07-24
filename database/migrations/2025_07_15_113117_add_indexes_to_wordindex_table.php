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
            $table->index('word', 'wordindex_word_index');
            $table->index('explanation', 'wordindex_explanation_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wordIndex', function (Blueprint $table) {
            $table->dropIndex('wordindex_word_index');
            $table->dropIndex('wordindex_explanation_index');
        });
    }
};
