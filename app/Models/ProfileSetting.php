<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $table = 'profile_settings';

    /**
     * Get a setting value by key with an optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Set or update a setting value by key.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        \Illuminate\Support\Facades\Cache::forget('portfolio.settings_profile_v3');
        \Illuminate\Support\Facades\Cache::forget('portfolio.settings_v3');
    }

    /**
     * Get all settings as a key=>value array.
     */
    public static function allAsArray(): array
    {
        return static::all()->pluck('value', 'key')->map(function ($val) {
            return ($val === '' ? null : $val);
        })->toArray();
    }
}
