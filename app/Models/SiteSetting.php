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
     * Get a setting value
     */
    public static function get(string $key, $default = null)
    {
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
