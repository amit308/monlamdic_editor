<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class WordIndex extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wordIndex';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'wordIndexId';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'word',
        'explanation',
        'note',
        'Key_Word',
        'origin',
        'image',
        'pending',
        'archaic',
        'grammar_Noun',
        'grammar_Verb',
        'grammar_Adjective',
        'grammar_Adverb',
        'grammar_LinkingVerb',
        'grammar_Pronoun',
        'grammar_Particle',
        'grammar_Interjection',
        'grammar__similarity',
        'grammar_synonymy',
        'grammar_numeral',
        'grammar_quantifier',
        'terminology_1',
        'terminology_2',
        'terminology_3',
        'terminology_4',
        'terminology_5',
        'terminology_6',
        'terminology_7',
        'terminology_8',
        'terminology_9',
        'terminology_10',
        'terminology_12',
        'terminology_11',
        'terminology_13',
        'terminology_14',
        'terminology_15',
        'terminology_16',
        'terminology_17',
        'terminology_19',
        'terminology_18',
        'terminology_21',
        'terminology_20',
        'havepery',
        'newword',
        'newdelpa',
        'internationalPhonetic',
        'Phonetic_amdo',
        'Phonetic_lhasa',
        'Phonetic_kham',
        'Noun_Tayp',
        'use',
        'old_orthography',
        'editor',
        'editor_group',
        'dateTime',
        'monlamItEmploye',
        'temp3',
        'temp4',
        'temp5',
        'temp6',
        'temp_text',
        'temp_text1',
        'temp_text2',
        'wordCn',
        'explanationCn',
        'created_by',
        'updated_by',
        'last_modified_by',
    ];
    
    /**
     * Get the user who created this word.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Get the user who last updated this word.
     */
    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by');
    }
}
