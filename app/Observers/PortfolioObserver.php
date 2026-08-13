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
        // Clear current cache keys only
        $keys = [
            'portfolio.home_data_v4',
            'portfolio.about_data_v3',
            'portfolio.contact_profile_v3',
            'portfolio.settings_v3',
            'portfolio.settings_profile_v3',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear paginated project caches
        for ($i = 1; $i <= 20; $i++) {
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
