<?php

namespace App\Http\Controllers;

use App\Models\WordIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DictionarySearchController extends Controller
{
    /**
     * Display the dictionary search homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get dictionary statistics for display on the search page
        $stats = [
            'total_words' => WordIndex::count(),
            'new_words' => WordIndex::where('newword', 1)->count(),
        ];

        // Get some featured or recent words (limit to 5)
        $featuredWords = WordIndex::latest('wordIndexId')
            ->take(5)
            ->get();

        return view('dictionary.index', [
            'stats' => $stats,
            'featuredWords' => $featuredWords
        ]);
    }

    /**
     * Process a dictionary search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = WordIndex::query();
        $searchTerm = $request->input('search_term');
        $searchType = $request->input('search_type', 'contains');
        $searchField = $request->input('search_field', 'word');

        // Build search query based on parameters
        if (!empty($searchTerm)) {
            $searchPattern = $searchType === 'contains' ? "%{$searchTerm}%" : "{$searchTerm}%";
            
            // If searching in all fields
            if ($searchField === 'all') {
                $query->where(function($q) use ($searchPattern) {
                    $q->where('word', 'LIKE', $searchPattern)
                      ->orWhere('explanation', 'LIKE', $searchPattern)
                      ->orWhere('note', 'LIKE', $searchPattern);
                });
            } else {
                // Search in specific field
                $query->where($searchField, 'LIKE', $searchPattern);
            }
        }

        // Apply any filters if needed
        if ($request->filled('filters')) {
            $filters = $request->input('filters');
            
            // Example filter for grammatical category
            if (isset($filters['grammar']) && !empty($filters['grammar'])) {
                $grammarField = 'grammar_' . $filters['grammar'];
                $query->where($grammarField, 1);
            }
            
            // Filter for new words if requested
            if (isset($filters['newword']) && $filters['newword']) {
                $query->where('newword', 1);
            }
            
            // Filter for archaic words if requested
            if (isset($filters['archaic']) && $filters['archaic']) {
                $query->where('archaic', 1);
            }
        }

        // Get results with pagination
        $results = $query->orderBy('word')->paginate(20);
        
        // Preserve search parameters for pagination links
        $results->appends($request->all());

        return view('dictionary.search_results', [
            'results' => $results,
            'searchTerm' => $searchTerm,
            'searchType' => $searchType,
            'searchField' => $searchField
        ]);
    }
}
