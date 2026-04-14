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

    protected $appends = ['duration', 'date_range'];

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
        $start = $this->start_date->format('M Y');
        $end = $this->is_current ? 'Present' : ($this->end_date ? $this->end_date->format('M Y') : '');

        return $start.' - '.$end;
    }
}
