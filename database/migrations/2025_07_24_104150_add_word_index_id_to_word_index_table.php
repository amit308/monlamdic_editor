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
        // Create a new temporary table with the correct structure
        Schema::create('wordIndex_new', function (Blueprint $table) {
            $table->bigIncrements('wordIndexId');
            $table->string('word', 255);
            $table->text('explanation')->nullable();
            $table->boolean('newword')->default(false);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_modified_by')->nullable();
            
            // Add word index using the schema builder
            $table->index('word', 'wordindex_word_index');
            
            // For MySQL, we'll add the explanation index after the table is created
            // since it requires a key length specification for TEXT columns
        });
        
        // Copy data from the old table to the new one
        if (Schema::hasTable('wordIndex')) {
            $records = DB::table('wordIndex')->get();
            
            foreach ($records as $record) {
                DB::table('wordIndex_new')->insert([
                    'wordIndexId' => $record->id,
                    'word' => $record->word,
                    'explanation' => $record->explanation,
                    'newword' => $record->newword ?? false,
                    'created_at' => $record->created_at,
                    'updated_at' => $record->updated_at,
                    'created_by' => $record->created_by ?? null,
                    'last_modified_by' => $record->last_modified_by ?? null,
                ]);
            }
            
            // Drop the old table
            Schema::dropIfExists('wordIndex');
            
            // Rename the new table to the original name
            Schema::rename('wordIndex_new', 'wordIndex');
            
            // For MySQL, add the explanation index after the table is created
            if (config('database.default') === 'mysql') {
                \DB::statement('CREATE INDEX wordindex_explanation_index ON wordIndex(explanation(255))');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create a backup of the current table with the original structure
        Schema::create('wordIndex_old', function (Blueprint $table) {
            $table->id();
            $table->string('word', 255);
            $table->text('explanation')->nullable();
            $table->boolean('newword')->default(false);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_modified_by')->nullable();
            
            // Add word index using the schema builder
            $table->index('word', 'wordindex_word_index');
            
            // For MySQL, we'll add the explanation index after the table is created
            // since it requires a key length specification for TEXT columns
        });
        
        // Copy data from the current table to the backup
        if (Schema::hasTable('wordIndex')) {
            $records = DB::table('wordIndex')->get();
            
            foreach ($records as $record) {
                DB::table('wordIndex_old')->insert([
                    'id' => $record->wordIndexId,
                    'word' => $record->word,
                    'explanation' => $record->explanation,
                    'newword' => $record->newword,
                    'created_at' => $record->created_at,
                    'updated_at' => $record->updated_at,
                    'created_by' => $record->created_by,
                    'last_modified_by' => $record->last_modified_by,
                ]);
            }
            
            // Drop the current table
            Schema::dropIfExists('wordIndex');
            
            // Rename the backup table to the original name
            Schema::rename('wordIndex_old', 'wordIndex');
            
            // For MySQL, add the explanation index after the table is created
            if (config('database.default') === 'mysql') {
                \DB::statement('CREATE INDEX wordindex_explanation_index ON wordIndex(explanation(255))');
            }
        }
    }
};
