<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupInactiveSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:cleanup 
                            {--days=30 : Number of days of inactivity before a session is considered stale}
                            {--dry-run : Do not perform any deletions, only show what would be done}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up inactive user sessions from the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $dryRun = $this->option('dry-run');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info('Cleaning up sessions inactive for more than ' . $days . ' days (before ' . $cutoffDate->format('Y-m-d H:i:s') . ')' . ($dryRun ? ' [DRY RUN]' : ''));

        // Get inactive sessions
        $inactiveSessions = DB::table('sessions')
            ->where('last_activity', '<', $cutoffDate->timestamp)
            ->get(['id', 'user_id', 'ip_address', 'user_agent', 'last_activity']);

        $count = $inactiveSessions->count();

        if ($count === 0) {
            $this->info('No inactive sessions found.');
            return 0;
        }

        // Display what would be deleted
        $this->table(
            ['ID', 'User ID', 'IP Address', 'Last Activity', 'User Agent'],
            $inactiveSessions->map(function ($session) {
                return [
                    $session->id,
                    $session->user_id ?? 'Guest',
                    $session->ip_address,
                    date('Y-m-d H:i:s', $session->last_activity),
                    substr($session->user_agent ?? '', 0, 50) . (strlen($session->user_agent ?? '') > 50 ? '...' : '')
                ];
            })
        );

        $this->info("Found $count inactive sessions.");

        if ($dryRun) {
            $this->info('Dry run completed. No changes were made.');
            return 0;
        }

        // Confirm before deleting
        if (!$this->confirm("Are you sure you want to delete $count inactive sessions?")) {
            $this->info('Operation cancelled.');
            return 1;
        }

        // Delete the sessions
        $deleted = DB::table('sessions')
            ->where('last_activity', '<', $cutoffDate->timestamp)
            ->delete();

        $this->info("Successfully deleted $deleted inactive sessions.");
        
        // Log the cleanup
        Log::info("Cleaned up $deleted inactive sessions older than $days days");

        return 0;
    }
}
