<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'type',
        'title',
        'company',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'highlights',
        'logo_url',
        'location_photo',
        'link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'highlights' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = ['duration', 'date_range', 'location_photo_url'];

    /**
     * Scope: filter by type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: only active experiences
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: only current experiences
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope: order by date and sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('start_date');
    }

    /**
     * Get duration in years and months
     */
    public function getDurationAttribute(): string
    {
        $start = $this->start_date;
        if (! $start) {
            return '';
        }
        $end = $this->is_current ? now() : $this->end_date;

        if (! $end) {
            return 'Present';
        }

        $diff = $start->diff($end);

        if ($diff->y > 0) {
            return $diff->y.' year'.($diff->y > 1 ? 's' : '').
                   ($diff->m > 0 ? ' '.$diff->m.' month'.($diff->m > 1 ? 's' : '') : '');
        }

        return $diff->m.' month'.($diff->m > 1 ? 's' : '');
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute(): string
    {
        if (! $this->start_date) {
            return '';
        }
        $start = $this->start_date->format('M Y');
        $end = $this->is_current ? 'Present' : ($this->end_date ? $this->end_date->format('M Y') : '');

        return $start.($end ? ' - '.$end : '');
    }

    /**
     * Get logo URL with dynamic host & port support
     */
    public function getLogoUrlFormattedAttribute(): ?string
    {
        if (!$this->logo_url) {
            return null;
        }

        if (str_starts_with($this->logo_url, 'http://') || str_starts_with($this->logo_url, 'https://')) {
            return $this->logo_url;
        }

        $host = app()->runningInConsole() ? config('app.url') : request()->getSchemeAndHttpHost();
        return rtrim($host, '/') . '/storage/' . ltrim($this->logo_url, '/');
    }

    /**
     * Get location photo URL with dynamic host & port support & smart fallback per type
     */
    public function getLocationPhotoUrlAttribute(): string
    {
        if ($this->location_photo) {
            if (str_starts_with($this->location_photo, 'http://') || str_starts_with($this->location_photo, 'https://')) {
                return $this->location_photo;
            }

            $host = app()->runningInConsole() ? config('app.url') : request()->getSchemeAndHttpHost();
            return rtrim($host, '/') . '/storage/' . ltrim($this->location_photo, '/');
        }

        // Smart architectural fallback per type
        if ($this->type === 'work') {
            return 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=800&auto=format&fit=crop';
        }

        if ($this->type === 'education') {
            if (str_contains(strtolower($this->title . ' ' . $this->company), 'universit') || str_contains(strtolower($this->title . ' ' . $this->company), 'institut') || str_contains(strtolower($this->title . ' ' . $this->company), 'polytechnic')) {
                return 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=800&auto=format&fit=crop';
            }
            return 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop';
        }

        return 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=800&auto=format&fit=crop';
    }
}
