<?php

namespace App\Http\Controllers;

use App\Models\WordIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WordIndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Authentication is handled through route middleware in web.php
        // No need for middleware here
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WordIndex::query();

        // Advanced search functionality
        $wordSearchType = $request->input('word_search_type', 'contains');
        $explanationSearchType = $request->input('explanation_search_type', 'contains');
        
        // Word search
        if ($request->filled('word_search')) {
            $wordSearchTerm = $request->word_search;
            $wordPattern = $wordSearchType === 'contains' ? "%{$wordSearchTerm}%" : "{$wordSearchTerm}%";
            $query->where('word', 'LIKE', $wordPattern);
        }

        // Explanation search
        if ($request->filled('explanation_search')) {
            $explanationSearchTerm = $request->explanation_search;
            $explanationPattern = $explanationSearchType === 'contains' ? "%{$explanationSearchTerm}%" : "{$explanationSearchTerm}%";
            
            // If word search is also applied, we need to ensure both conditions are met
            if ($request->filled('word_search')) {
                $query->where('explanation', 'LIKE', $explanationPattern);
            } else {
                $query->where('explanation', 'LIKE', $explanationPattern);
            }
        }

        // Legacy search - for backward compatibility
        if (!$request->filled('word_search') && !$request->filled('explanation_search') && $request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('word', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('explanation', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Pagination
        $entries = $query->orderBy('word')->paginate(20);
        
        // Pass search params back to the view
        $searchParams = [
            'word_search' => $request->input('word_search'),
            'word_search_type' => $wordSearchType,
            'explanation_search' => $request->input('explanation_search'),
            'explanation_search_type' => $explanationSearchType,
            'search' => $request->input('search')
        ];

        return view('wordindex.index', compact('entries', 'searchParams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wordindex.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the necessary columns exist in the table
        $hasTrackingColumns = Schema::hasColumns('wordIndex', ['created_by', 'created_at', 'updated_at', 'last_modified_by']);
        
        $validated = $request->validate([
            'word' => 'required|max:3000',
            'explanation' => 'nullable',
            'explanationCn' => 'nullable',
            'note' => 'nullable',
            'wordCn' => 'nullable',
            'Key_Word' => 'nullable|max:100',
            'origin' => 'nullable|max:300',
            // Grammar fields
            'grammar_Noun' => 'sometimes',
            'grammar_Verb' => 'sometimes',
            'grammar_Adjective' => 'sometimes',
            'grammar_Adverb' => 'sometimes',
            'grammar_LinkingVerb' => 'sometimes',
            'grammar_Pronoun' => 'sometimes',
            'grammar_Particle' => 'sometimes',
            'grammar_Interjection' => 'sometimes',
            'grammar__similarity' => 'sometimes',
            'grammar_synonymy' => 'sometimes',
            'grammar_numeral' => 'sometimes',
            'grammar_quantifier' => 'sometimes',
            'Noun_Tayp' => 'nullable',
            // Status fields
            'archaic' => 'sometimes',
            'pending' => 'sometimes',
            'newword' => 'sometimes',
            // Phonetics fields
            'internationalPhonetic' => 'nullable',
            'Phonetic_amdo' => 'nullable',
            'Phonetic_lhasa' => 'nullable',
            'Phonetic_kham' => 'nullable',
            // Terminology & Domain
            'domain' => 'nullable',
            'subject' => 'nullable',
            'termType' => 'nullable',
            // Status & Metadata
            'status' => 'nullable',
            'author' => 'nullable',
            'source' => 'nullable',
            // Editor information
            'editor' => 'nullable',
            'editor_group' => 'nullable',
        ]);
        
        // Handle checkbox fields explicitly for the create form
        $booleanFields = [
            'grammar_Noun', 'grammar_Verb', 'grammar_Adjective', 'grammar_Adverb', 'grammar_LinkingVerb',
            'grammar_Pronoun', 'grammar_Particle', 'grammar_Interjection', 'grammar__similarity',
            'grammar_synonymy', 'grammar_numeral', 'grammar_quantifier',
            'archaic', 'pending', 'newword'
        ];
        
        foreach ($booleanFields as $field) {
            if (!isset($validated[$field])) {
                $validated[$field] = 0;
            }
        }

        // Create a new entry with tracking information if columns exist
        $wordIndexData = $request->all();
        
        // Add the current user's name to the editor field if not already filled
        if (empty($wordIndexData['editor']) && Auth::user()) {
            $wordIndexData['editor'] = Auth::user()->name;
        }
        
        // Store the current date and time
        $wordIndexData['dateTime'] = now();
        
        // Create new instance and fill with data
        $wordIndex = new WordIndex;
        
        // Set attributes from the request
        foreach ($wordIndexData as $key => $value) {
            $wordIndex->$key = $value;
        }
        
        // Add tracking information
        if (Auth::check()) {
            $wordIndex->created_by = Auth::id();
            $wordIndex->last_modified_by = Auth::id();
        }
        
        // Save the record
        $wordIndex->save();

        return redirect()->route('wordindex.index')
            ->with('success', 'Dictionary entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WordIndex $wordindex)
    {
        // Parameter name now matches route resource name
        return view('wordindex.show', compact('wordindex'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WordIndex $wordindex)
    {
        // Parameter name now matches route resource name
        return view('wordindex.edit', compact('wordindex'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WordIndex $wordindex)
    {
        // Debug: Log the request data to see what's coming in
        \Log::info('Update Request Data', ['request' => $request->all(), 'id' => $wordindex->wordIndexId]);
        
        try {
            $validated = $request->validate([
                'word' => 'required|max:3000',
                'explanation' => 'nullable',
                'explanationCn' => 'nullable',
                'note' => 'nullable',
                'wordCn' => 'nullable',
                'Key_Word' => 'nullable|max:100',
                'origin' => 'nullable|max:300',
                // Grammar fields
                'grammar_Noun' => 'sometimes',
                'grammar_Verb' => 'sometimes',
                'grammar_Adjective' => 'sometimes',
                'grammar_Adverb' => 'sometimes',
                'grammar_LinkingVerb' => 'sometimes',
                'grammar_Pronoun' => 'sometimes',
                'grammar_Particle' => 'sometimes',
                'grammar_Interjection' => 'sometimes',
                'grammar__similarity' => 'sometimes',
                'grammar_synonymy' => 'sometimes',
                'grammar_numeral' => 'sometimes',
                'grammar_quantifier' => 'sometimes',
                'Noun_Tayp' => 'nullable',
                // Status fields
                'archaic' => 'nullable|boolean',
                'pending' => 'nullable|boolean',
                'newword' => 'nullable|boolean',
                // Phonetics fields
                'internationalPhonetic' => 'nullable',
                'Phonetic_amdo' => 'nullable',
                'Phonetic_lhasa' => 'nullable',
                'Phonetic_kham' => 'nullable',
                // Terminology & Domain
                'domain' => 'nullable',
                'subject' => 'nullable',
                'termType' => 'nullable',
                // Status & Metadata
                'status' => 'nullable',
                'author' => 'nullable',
                'source' => 'nullable',
                // Editor information
                'editor' => 'nullable',
                'editor_group' => 'nullable',
            ]);
            
            // Debug: Log the validated data
            \Log::info('Validated Data', $validated);
            
            // Handle checkbox fields - explicitly set them to 0 if not present in the request
            $booleanFields = [
                'grammar_Noun', 'grammar_Verb', 'grammar_Adjective', 'grammar_Adverb', 'grammar_LinkingVerb',
                'grammar_Pronoun', 'grammar_Particle', 'grammar_Interjection', 'grammar__similarity',
                'grammar_synonymy', 'grammar_numeral', 'grammar_quantifier',
                'archaic', 'pending', 'newword'
            ];
            
            foreach ($booleanFields as $field) {
                if (!isset($validated[$field])) {
                    $wordindex->$field = 0;
                }
            }
            
            // Add the current user's name to the editor field if not already filled
            if (empty($validated['editor']) && Auth::user()) {
                $validated['editor'] = Auth::user()->name;
            }
            
            // Store the current date and time of modification
            $validated['dateTime'] = now();
            
            // Add tracking information
            if (Auth::check()) {
                $validated['last_modified_by'] = Auth::id();
            }
            
            // Update the record
            $updated = $wordindex->update($validated);
            
            // Debug: Log the update result
            \Log::info('Update Result', ['success' => $updated, 'model' => $wordindex->toArray()]);
            
            return redirect()->route('wordindex.index')
                ->with('success', 'Dictionary entry updated successfully.');
        } catch (\Exception $e) {
            // Log any errors that occur
            \Log::error('Update Error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WordIndex $wordindex)
    {
        $wordindex->delete();

        return redirect()->route('wordindex.index')
            ->with('success', 'Dictionary entry deleted successfully.');
    }
}
