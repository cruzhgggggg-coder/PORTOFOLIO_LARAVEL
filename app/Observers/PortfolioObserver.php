<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class PortfolioObserver
{
    /**
     * Clear all portfolio-related caches.
     */
    protected function clearCache(): void
    {
        // Simple strategy: Clear all keys starting with 'portfolio.'
        // Note: For File/Database cache drivers, we might need a more specific approach
        // if we don't want to flush the whole cache.
        // For simplicity in a portfolio, we can flush or use specific keys.
        
        Cache::forget('portfolio.home_data');
        Cache::forget('portfolio.about_data');
        Cache::forget('portfolio.contact_profile');
        Cache::forget('portfolio.settings');
        Cache::forget('portfolio.settings_profile');
        
        // Since we don't know all page numbers for projects, we can either use tags (if supported)
        // or just clear the first few pages or flush if the site is small.
        // Or better yet, we can use a cache tag if the driver supports it (redis/memcached).
        // Since we likely use 'file' or 'database' in shared hosting:
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("portfolio.projects_page_{$i}");
        }
    }

    public function saved($model): void
    {
        // For Projects, don't clear cache if only views or likes were incremented
        if ($model instanceof \App\Models\Project) {
            $changes = $model->getChanges();
            $analyticKeys = ['views_count', 'likes_count', 'updated_at'];
            
            // Check if there are any changes other than analytics
            $hasRealChanges = false;
            foreach ($changes as $key => $value) {
                if (!in_array($key, $analyticKeys)) {
                    $hasRealChanges = true;
                    break;
                }
            }

            if (!$hasRealChanges) {
                return;
            }
        }

        $this->clearCache();
    }

    public function deleted($model): void
    {
        $this->clearCache();
    }

    public function restored($model): void
    {
        $this->clearCache();
    }
}
