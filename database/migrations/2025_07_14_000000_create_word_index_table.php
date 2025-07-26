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
        // First create the table without the problematic index
        Schema::create('wordIndex', function (Blueprint $table) {
            $table->id('wordIndexId');
            $table->string('word', 3000)->nullable();
            $table->text('explanation')->nullable();
            $table->text('note')->nullable();
            $table->string('Key_Word', 100)->nullable();
            $table->string('origin', 300)->nullable();
            $table->binary('image')->nullable();
            $table->string('pending', 100)->nullable();
            $table->string('archaic', 100)->nullable();
            $table->string('grammar_Noun', 100)->nullable();
            $table->string('grammar_Verb', 100)->nullable();
            $table->string('grammar_Adjective', 100)->nullable();
            $table->string('grammar_Adverb', 100)->nullable();
            $table->string('grammar_LinkingVerb', 100)->nullable();
            $table->string('grammar_Pronoun', 100)->nullable();
            $table->string('grammar_Particle', 100)->nullable();
            $table->string('grammar_Interjection', 100)->nullable();
            $table->string('grammar__similarity', 100)->nullable();
            $table->string('grammar_synonymy', 100)->nullable();
            $table->string('grammar_numeral', 100)->nullable();
            $table->string('grammar_quantifier', 100)->nullable();
            $table->string('terminology_1', 100)->nullable();
            $table->string('terminology_2', 100)->nullable();
            $table->string('terminology_3', 100)->nullable();
            $table->string('terminology_4', 100)->nullable();
            $table->string('terminology_5', 100)->nullable();
            $table->string('terminology_6', 100)->nullable();
            $table->string('terminology_7', 100)->nullable();
            $table->string('terminology_8', 100)->nullable();
            $table->string('terminology_9', 100)->nullable();
            $table->string('terminology_10', 100)->nullable();
            $table->string('terminology_11', 100)->nullable();
            $table->string('terminology_12', 100)->nullable();
            $table->string('terminology_13', 100)->nullable();
            $table->string('terminology_14', 100)->nullable();
            $table->string('terminology_15', 100)->nullable();
            $table->string('terminology_16', 100)->nullable();
            $table->string('terminology_17', 100)->nullable();
            $table->string('terminology_18', 100)->nullable();
            $table->string('terminology_19', 100)->nullable();
            $table->string('terminology_20', 100)->nullable();
            $table->string('terminology_21', 100)->nullable();
            $table->string('havepery', 100)->nullable();
            $table->string('newword', 100)->nullable();
            $table->string('newdelpa', 100)->nullable();
            $table->string('internationalPhonetic', 1000)->nullable();
            $table->string('Phonetic_amdo', 300)->nullable();
            $table->string('Phonetic_lhasa', 300)->nullable();
            $table->string('Phonetic_kham', 300)->nullable();
            $table->string('Noun_Tayp', 100)->nullable();
            $table->string('use', 150)->nullable();
            $table->string('old_orthography', 150)->nullable();
            $table->string('editor', 500)->nullable();
            $table->string('editor_group', 500)->nullable();
            $table->string('dateTime', 50)->nullable();
            $table->string('monlamItEmploye', 300)->nullable();
            $table->string('temp3', 300)->nullable();
            $table->string('temp4', 300)->nullable();
            $table->string('temp5', 300)->nullable();
            $table->string('temp6', 300)->nullable();
            $table->text('temp_text')->nullable();
            $table->text('temp_text1')->nullable();
            $table->text('temp_text2')->nullable();
            $table->string('wordCn', 2000)->nullable();
            $table->text('explanationCn')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_modified_by')->nullable();
            $table->timestamps();
            
            // Add other important indexes
            $table->index('Key_Word', 'key_word_index');
            $table->index('origin', 'origin_index');
        });
        
        // Add prefix index using raw SQL after table creation
        DB::statement('CREATE INDEX word_prefix_index ON wordIndex (word(100))');
        
        // Add fulltext index for search (MySQL only)
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE wordIndex ADD FULLTEXT fulltext_explanation (explanation)');
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
