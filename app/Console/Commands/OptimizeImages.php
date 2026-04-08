<?php

namespace App\Console\Commands;

use App\Models\ProfileSetting;
use App\Models\Project;
use App\Services\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'images:optimize {--force : Force re-optimization of already optimized images}';

    /**
     * The console command description.
     */
    protected $description = 'Optimize all existing images in storage (convert to WebP, compress, resize)';

    protected ImageOptimizer $optimizer;

    /**
     * Execute the console command.
     */
    public function handle(ImageOptimizer $optimizer): int
    {
        $this->optimizer = $optimizer;

        $this->info('🚀 Starting image optimization...');
        $this->newLine();

        $results = $this->optimizer->optimizeAllExisting();

        // Update database references to use WebP
        $this->updateDatabaseReferences();

        $this->newLine();
        $this->info("✅ Optimization complete!");
        $this->newLine();

        $this->table(
            ['Folder', 'Optimized'],
            [
                ['Profile Photos', $results['profile']],
                ['Project Images', $results['projects']],
                ['Total', $results['profile'] + $results['projects']],
            ]
        );

        if (!empty($results['errors'])) {
            $this->newLine();
            $this->error('❌ Encountered ' . count($results['errors']) . ' error(s):');
            foreach ($results['errors'] as $error) {
                $this->line("   - $error");
            }
        }

        $this->newLine();
        $this->info('💡 All images are now optimized in WebP format for better performance!');

        return Command::SUCCESS;
    }

    /**
     * Update all database references to use WebP versions
     */
    protected function updateDatabaseReferences(): void
    {
        $this->info('🔄 Updating database references...');

        $updated = 0;

        // Update profile photos
        $profilePhotos = ProfileSetting::where('key', 'photo_url')->get();
        foreach ($profilePhotos as $setting) {
            if ($setting->value && !str_ends_with(parse_url($setting->value, PHP_URL_PATH), '.webp')) {
                $setting->value = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $setting->value);
                $setting->save();
                $updated++;
            }
        }

        // Update project images
        $projects = Project::whereNotNull('image_url')->get();
        foreach ($projects as $project) {
            if ($project->image_url && str_starts_with($project->image_url, '/storage/') && !str_ends_with(parse_url($project->image_url, PHP_URL_PATH), '.webp')) {
                $project->image_url = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $project->image_url);
                $project->save();
                $updated++;
            }
        }

        $this->info("   ✓ Updated $updated database reference(s)");
    }
}
