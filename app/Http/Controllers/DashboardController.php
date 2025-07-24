<?php

namespace App\Http\Controllers;

use App\Models\WordIndex;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with dictionary statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get dictionary statistics
        $stats = [
            'total_words' => WordIndex::count(),
            'new_words' => WordIndex::where('newword', 1)->count(),
            'pending_words' => WordIndex::where('pending', 1)->count(),
            'archaic_words' => WordIndex::where('archaic', 1)->count(),
        ];

        // Check if the tracking columns exist in the database
        $hasTrackingColumns = Schema::hasColumns('wordIndex', ['created_by', 'last_modified_by']);
        
        // Get latest added words
        $query = WordIndex::latest('wordIndexId');
        
        // Only join with users table if the tracking columns exist
        if ($hasTrackingColumns) {
            $query->select('wordIndex.*', 'u1.name as creator_name', 'u2.name as modifier_name')
                ->leftJoin('users as u1', 'wordIndex.created_by', '=', 'u1.id')
                ->leftJoin('users as u2', 'wordIndex.last_modified_by', '=', 'u2.id');
        }
        
        $latestWords = $query->take(5)->get();
        
        // If tracking columns don't exist, add placeholder properties
        if (!$hasTrackingColumns) {
            foreach ($latestWords as $word) {
                $word->creator_name = null;
                $word->modifier_name = null;
            }
        }
        
        // For words that don't have new tracking columns, use the editor field
        foreach ($latestWords as $word) {
            if (empty($word->creator_name) && !empty($word->editor)) {
                $word->creator_name = $word->editor;
                $word->modifier_name = $word->editor;
            }
            
            // Determine if this is a new word or an edited one
            // Check for created_at, updated_at fields
            if ($word->created_at && $word->updated_at) {
                // If created_at and updated_at are very close (less than 1 minute apart), consider it new
                $created = new \DateTime($word->created_at);
                $updated = new \DateTime($word->updated_at);
                $diff = $created->diff($updated);
                
                $word->is_new = $diff->i < 1 && $diff->h === 0 && $diff->d === 0;
                $word->is_edited = !$word->is_new;
            } else {
                // If tracking columns don't exist, use newword flag
                $word->is_new = $word->newword == 1;
                $word->is_edited = !$word->is_new;
            }
        }

        return view('dashboard', [
            'stats' => $stats,
            'latestWords' => $latestWords
        ]);
    }
}
