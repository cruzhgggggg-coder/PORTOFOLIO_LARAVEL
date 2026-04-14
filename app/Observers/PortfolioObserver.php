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

        // New _v3 JSON cache keys
        Cache::forget('portfolio.home_data_v3');
        Cache::forget('portfolio.about_data_v3');
        Cache::forget('portfolio.contact_profile_v3');
        Cache::forget('portfolio.settings_v3');
        Cache::forget('portfolio.settings_profile_v3');
        
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("portfolio.projects_page_{$i}");
            Cache::forget("portfolio.projects_page_v3_{$i}");
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
