<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'proficiency' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = ['proficiency_percent', 'proficiency_level'];

    /**
     * Scope: only active skills
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get proficiency percentage (already 0-100)
     */
    public function getProficiencyPercentAttribute(): int
    {
        return $this->proficiency;
    }

    /**
     * Get proficiency level label
     */
    public function getProficiencyLevelAttribute(): string
    {
        return match (true) {
            $this->proficiency >= 90 => 'Expert',
            $this->proficiency >= 75 => 'Advanced',
            $this->proficiency >= 60 => 'Intermediate',
            $this->proficiency >= 40 => 'Beginner',
            default => 'Learning',
        };
    }
}
