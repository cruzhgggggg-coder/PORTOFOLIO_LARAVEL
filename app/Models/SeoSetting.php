<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'page_key',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'canonical_url',
        'no_index',
        'custom_meta',
    ];

    protected $casts = [
        'no_index' => 'boolean',
        'custom_meta' => 'array',
    ];

    /**
     * Get SEO setting by page key
     */
    public static function getByPage(string $key, ?array $defaults = null): ?self
    {
        $setting = self::where('page_key', $key)->first();

        if (! $setting && $defaults) {
            $setting = self::create(array_merge(['page_key' => $key], $defaults));
        }

        return $setting;
    }

    /**
     * Get meta tags array for rendering
     */
    public function getMetaTagsAttribute(): array
    {
        $meta = [
            'title' => $this->meta_title,
            'description' => $this->meta_description,
            'keywords' => $this->meta_keywords,
            'og:image' => $this->og_image,
            'canonical' => $this->canonical_url,
            'no_index' => $this->no_index,
        ];

        if ($this->custom_meta) {
            $meta = array_merge($meta, $this->custom_meta);
        }

        return array_filter($meta, fn ($value) => $value !== null);
    }
}
