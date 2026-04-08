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
        
        if (!$setting) {
            return $default;
        }

        // Cast value based on type
        return match($setting->type) {
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
        $settingValue = match($type) {
            'json' => json_encode($value),
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
        return self::all()->pluck('value', 'key')->toArray();
    }

    /**
     * Check if site is in maintenance mode
     */
    public static function isMaintenanceMode(): bool
    {
        return (bool) self::get('maintenance_mode', false);
    }
}
