<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /**
     * Runtime cache for settings loaded in this request
     */
    protected static array $runtimeCache = [];

    /**
     * Set runtime cache from preloaded settings array
     */
    public static function setRuntimeCache(array $settings): void
    {
        self::$runtimeCache = $settings;
    }

    /**
     * Get a setting value (checks runtime cache first, then DB)
     */
    public static function get(string $key, $default = null)
    {
        // Check runtime cache first (set by AppServiceProvider)
        if (array_key_exists($key, self::$runtimeCache)) {
            $value = self::$runtimeCache[$key];
            return ($value === '' || $value === null) ? $default : $value;
        }

        // Fallback to DB query
        $setting = self::where('key', $key)->first();

        if (! $setting || $setting->value === '' || $setting->value === null) {
            return $default;
        }

        // Cast value based on type
        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'json' => json_decode($setting->value, true),
            'integer' => (int) $setting->value,
            default => $setting->value,
        };
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, string $type = 'text'): self
    {
        $setting = self::firstOrCreate(['key' => $key]);

        // Encode value based on type
        $settingValue = match ($type) {
            'json' => is_array($value) ? json_encode($value) : $value,
            default => (string) $value,
        };

        $setting->update([
            'value' => $settingValue,
            'type' => $type,
        ]);

        \Illuminate\Support\Facades\Cache::forget('portfolio.settings_v3');
        \Illuminate\Support\Facades\Cache::forget('portfolio.settings_profile_v3');

        return $setting;
    }

    /**
     * Get all settings as key-value pair
     */
    public static function allAsArray(): array
    {
        return self::all()->mapWithKeys(function ($setting) {
            $value = match ($setting->type) {
                'boolean' => (bool) $setting->value,
                'json' => json_decode($setting->value, true),
                'integer' => (int) $setting->value,
                default => $setting->value,
            };

            // If value is empty string but not boolean false, we might want to let the view handle defaults
            // but for safety, we return it as is and let Blade's ?? or @empty handle it.
            // However, to fix the user's issue, we should probably only return non-empty values
            // so that ?? works correctly in Blade.

            return [$setting->key => ($value === '' ? null : $value)];
        })->toArray();
    }

    /**
     * Check if site is in maintenance mode
     */
    public static function isMaintenanceMode(): bool
    {
        return (bool) self::get('maintenance_mode', false);
    }
}
