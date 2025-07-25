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
        // Check if we're using MySQL
        $isMySQL = config('database.default') === 'mysql';
        
        Schema::create('wordIndex', function (Blueprint $table) use ($isMySQL) {
            $table->id();
            
            // Define the word column with appropriate index
            $wordColumn = $isMySQL 
                ? $table->string('word', 255)  // Limited length for MySQL index
                : $table->string('word');
            
            $wordColumn->index('wordindex_word_index');
            
            // Add the explanation column
            $explanationColumn = $table->text('explanation')->nullable();
            
            $table->timestamps();
        });
        
        // For MySQL, add the explanation index with a key length
        if ($isMySQL) {
            \DB::statement('CREATE INDEX wordindex_explanation_index ON wordIndex(explanation(255))');
        } else {
            // For other databases, add a regular index
            Schema::table('wordIndex', function (Blueprint $table) {
                $table->index('explanation', 'wordindex_explanation_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wordIndex');
    }
};
