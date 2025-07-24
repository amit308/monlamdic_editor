<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Process;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CheckSecurityUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:check-updates 
                            {--no-interaction : Do not ask any interactive questions}
                            {--force : Force update checks even if recently run}
                            {--check-only : Only check for updates, do not apply them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for available security updates and outdated dependencies';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🔒 Starting security update check...');
        $this->newLine();

        // Check for Composer security advisories
        $this->checkComposerSecurity();
        $this->newLine();

        // Check for outdated packages
        $this->checkOutdatedPackages();
        $this->newLine();

        // Check for Node.js security updates if package.json exists
        if (file_exists(base_path('package.json'))) {
            $this->checkNpmSecurity();
            $this->newLine();
        }

        $this->info('✅ Security update check completed.');
        return 0;
    }

    /**
     * Check for security advisories using Composer
     */
    protected function checkComposerSecurity(): void
    {
        $this->info('🛡️  Checking for Composer security advisories...');

        try {
            $process = Process::run('composer audit --format=json');
            $output = json_decode($process->output(), true);

            if ($process->successful() && isset($output['abandoned']) && empty($output['abandoned'])) {
                $this->info('  ✓ No known security vulnerabilities found in Composer packages.');
                return;
            }

            if (isset($output['abandoned']) && is_array($output['abandoned'])) {
                $this->warn('  ⚠️  Found abandoned packages:');
                foreach ($output['abandoned'] as $package => $replacement) {
                    $message = "    - {$package}";
                    if ($replacement !== false) {
                        $message .= " (replacement: {$replacement})";
                    }
                    $this->line($message);
                }
                $this->newLine();
            }

            if (isset($output['advisories']) && is_array($output['advisories']) && !empty($output['advisories'])) {
                $this->error('  ❌ Found security vulnerabilities:');
                foreach ($output['advisories'] as $package => $advisories) {
                    $this->line("  Package: <fg=red>{$package}</>");
                    foreach ($advisories as $advisory) {
                        $this->line("    - {$advisory['title']} (CVE: {$advisory['cve']})");
                        $this->line("      Affected versions: {$advisory['affectedVersions']}");
                        $this->line("      More info: {$advisory['link']}");
                        $this->newLine();
                    }
                }

                if (!$this->option('check-only') && 
                    ($this->option('no-interaction') || $this->confirm('Would you like to try to update vulnerable packages?', true))) {
                    $this->call('composer', ['update', '--dry-run']);
                    if ($this->option('no-interaction') || $this->confirm('Apply these updates?', true)) {
                        $this->call('composer', ['update']);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error("  ❌ Error checking Composer security: " . $e->getMessage());
            Log::error('Composer security check failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Check for outdated Composer packages
     */
    protected function checkOutdatedPackages(): void
    {
        $this->info('🔄 Checking for outdated Composer packages...');

        try {
            $process = Process::run('composer outdated --direct --format=json');
            $output = json_decode($process->output(), true);

            if ($process->successful() && empty($output['installed'])) {
                $this->info('  ✓ All Composer packages are up to date.');
                return;
            }

            if (!empty($output['installed'])) {
                $this->warn('  ⚠️  Found outdated packages:');
                $this->table(
                    ['Package', 'Current', 'Latest', 'Status'],
                    array_map(function ($package) {
                        $status = $package['latest-status'] === 'semver-safe-update' ? 'Minor update available' : 'Update available';
                        return [
                            $package['name'],
                            $package['version'],
                            $package['latest'],
                            $status
                        ];
                    }, $output['installed'])
                );

                if (!$this->option('check-only') && 
                    ($this->option('no-interaction') || $this->confirm('Would you like to update outdated packages?', true))) {
                    $this->call('composer', ['update', '--dry-run']);
                    if ($this->option('no-interaction') || $this->confirm('Apply these updates?', true)) {
                        $this->call('composer', ['update']);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error("  ❌ Error checking outdated packages: " . $e->getMessage());
            Log::error('Outdated packages check failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Check for Node.js security updates using npm audit
     */
    protected function checkNpmSecurity(): void
    {
        $this->info('📦 Checking for npm security updates...');

        try {
            if (!file_exists(base_path('package-lock.json'))) {
                $this->warn('  ⚠️  package-lock.json not found. Run `npm install` first.');
                return;
            }

            $process = Process::run('npm audit --json');
            $output = json_decode($process->getOutput(), true);

            if ($process->successful() && empty($output['vulnerabilities'])) {
                $this->info('  ✓ No known security vulnerabilities found in npm packages.');
                return;
            }

            if (!empty($output['vulnerabilities'])) {
                $this->error("  ❌ Found {$output['vulnerabilities']['info']['vulnerabilities']['total']} security vulnerabilities:");
                
                foreach ($output['vulnerabilities'] as $package => $vuln) {
                    if (!is_array($vuln) || !isset($vuln['severity'])) continue;
                    
                    $severity = strtoupper($vuln['severity']);
                    $severityLower = strtolower($vuln['severity']);
                    $color = 'white';
                    
                    switch ($severityLower) {
                        case 'critical':
                        case 'high':
                            $color = 'red';
                            break;
                        case 'moderate':
                            $color = 'yellow';
                            break;
                    }
                    
                    $this->line("  <fg={$color}>[{$severity}] {$package} - " . ($vuln['title'] ?? 'No title') . " (via: " . ($vuln['via'][0] ?? 'unknown') . ")");
                    $this->line("    " . (isset($vuln['fixAvailable']) && $vuln['fixAvailable'] ? '✅ Fix available' : '❌ No fix available'));
                    $advId = is_array($vuln['via'] ?? null) ? ($vuln['via'][0] ?? '') : '';
                    $this->line("    More info: https://www.npmjs.com/advisories/" . $advId);
                    $this->newLine();
                }

                if (!$this->option('check-only') && 
                    ($this->option('no-interaction') || $this->confirm('Would you like to try to fix npm vulnerabilities?', true))) {
                    Process::run('npm audit fix --dry-run');
                    if ($this->option('no-interaction') || $this->confirm('Apply these fixes?', true)) {
                        Process::run('npm audit fix');
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error("  ❌ Error checking npm security: " . $e->getMessage());
            Log::error('npm security check failed', ['error' => $e->getMessage()]);
        }
    }
}
