<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class WordIndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the table exists, if not, run migrations first
        if (!Schema::hasTable('wordIndex')) {
            $this->command->warn('wordIndex table does not exist. Running migrations...');
            \Artisan::call('migrate');
            $this->command->info('Migrations completed.');
        }

        // Disable foreign key checks for MySQL
        if (config('database.default') === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        
        // Truncate the table if it exists
        try {
            DB::table('wordIndex')->truncate();
        } catch (\Exception $e) {
            // If truncate fails (e.g., in SQLite), delete all records
            DB::table('wordIndex')->delete();
        }
        
        // Path to the SQLite database
        $dbPath = database_path('sqlite/Monlamdit-2025.db');
        
        if (!File::exists($dbPath)) {
            $this->command->error("SQLite database not found at: " . $dbPath);
            return;
        }
        
        // Create a temporary SQLite connection configuration
        $sqliteConfig = [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ];
        
        // Set the configuration
        config(['database.connections.sqlite' => $sqliteConfig]);
        
        // Reconnect to the database with the new configuration
        DB::purge('sqlite');
        DB::reconnect('sqlite');
      
        try {
            // Get total number of records to migrate
            $totalRecords = DB::connection('sqlite')
                ->table('wordIndex')
                ->count();
                
            $this->command->info("Found $totalRecords records to migrate from SQLite to MySQL.");
            
            // Create a progress bar
            $bar = $this->command->getOutput()->createProgressBar($totalRecords);
            $bar->start();
            
            // Process records in smaller chunks to avoid memory issues
            $chunkSize = 50; // Reduced chunk size
            $processed = 0;
            $failedChunks = 0;
            $this->command->info("Starting to process chunks...");
            
            // Get the maximum ID to process
            $maxId = DB::connection('sqlite')
                ->table('wordIndex')
                ->max('wordIndexId');
                
            $this->command->info("Maximum wordIndexId in SQLite: $maxId");
            
            // Process in smaller batches using manual pagination
            $perPage = 1000; // Process 1000 records at a time
            $currentPage = 0;
            $totalProcessed = 0;
            
            do {
                $offset = $currentPage * $perPage;
                $this->command->info("Processing batch starting at offset $offset");
                
                // Get a batch of records
                $batch = DB::connection('sqlite')
                    ->table('wordIndex')
                    ->orderBy('wordIndexId')
                    ->offset($offset)
                    ->limit($perPage)
                    ->get();
                    
                $batchCount = count($batch);
                $this->command->info("Retrieved $batchCount records in batch $currentPage");
                
                if ($batchCount === 0) {
                    break; // No more records to process
                }
                
                // Process the batch in chunks
                $chunks = array_chunk($batch->toArray(), $chunkSize);
                
                foreach ($chunks as $chunk) {
                    $data = [];
                    
                    foreach ($chunk as $record) {
                        $data[] = (array) $record;
                    }
                    
                    // Insert the chunk into MySQL
                    if (!empty($data)) {
                        try {
                            $result = DB::table('wordIndex')->insert($data);
                            $processedCount = count($data);
                            $totalProcessed += $processedCount;
                            $processed += $processedCount;
                            
                            // Update progress bar
                            $bar->advance($processedCount);
                            
                            // Log progress every 1000 records
                            if ($processed % 1000 === 0) {
                                $this->command->info("Processed $processed records so far...");
                            }
                        } catch (\Exception $e) {
                            $failedChunks++;
                            $this->command->error("Error inserting chunk: " . $e->getMessage());
                            
                            // If a chunk fails, try inserting records one by one to identify the problematic record
                            $this->command->warn("Attempting to insert records one by one to identify the issue...");
                            
                            $successfulInChunk = 0;
                            foreach ($data as $singleRecord) {
                                try {
                                    DB::table('wordIndex')->insert($singleRecord);
                                    $successfulInChunk++;
                                    $processed++;
                                    $totalProcessed++;
                                    $bar->advance();
                                } catch (\Exception $singleE) {
                                    $this->command->error("Failed to insert record with wordIndexId={$singleRecord['wordIndexId']}: " . $singleE->getMessage());
                                    // Continue with the next record
                                }
                            }
                            
                            $this->command->info("Successfully inserted $successfulInChunk out of " . count($data) . " records in the failed chunk.");
                        }
                    }
                    
                    // Clear memory
                    unset($data);
                    
                    // Explicitly collect any garbage
                    if (function_exists('gc_collect_cycles')) {
                        gc_collect_cycles();
                    }
                }
                
                $currentPage++;
                
            } while (true); // Continue until we break out of the loop
            
            $bar->finish();
            $this->command->newLine(2);
            
            $this->command->info("Successfully migrated $processed records from SQLite to MySQL.");
            
        } catch (\Exception $e) {
            $this->command->error('Error during migration: ' . $e->getMessage());
            $this->command->error($e->getTraceAsString());
        } finally {
            // Re-enable foreign key checks for MySQL
            if (config('database.default') === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
            
            // Reconnect to the default database
            DB::purge('sqlite');
            config(['database.connections.sqlite.database' => ':memory:']);
        }
        
        // Add fulltext index for MySQL if using MySQL
        if (config('database.default') === 'mysql') {
            $this->command->info('Optimizing indexes for MySQL...');
            
            try {
                // Check if the fulltext index already exists
                $indexes = DB::select("SHOW INDEX FROM `wordIndex` WHERE Key_name = 'explanation_fulltext'");
                
                if (empty($indexes)) {
                    $this->command->info('Adding fulltext index on explanation field...');
                    DB::statement('ALTER TABLE `wordIndex` ADD FULLTEXT INDEX `explanation_fulltext` (`explanation`(1000))');
                    $this->command->info('Successfully added fulltext index on explanation field.');
                } else {
                    $this->command->info('Fulltext index already exists on explanation field.');
                }
                
            } catch (\Exception $e) {
                $this->command->warn('Could not add fulltext index: ' . $e->getMessage());
                $this->command->warn('This is not critical - the application will still work without it, but text searches may be slower.');
            }
        } else {
            $this->command->info('Skipping fulltext index creation for non-MySQL database.');
        }
    }
}
