<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'title',
        'company',
        'email',
        'avatar_url',
        'content',
        'rating',
        'project_name',
        'project_url',
        'is_featured',
        'is_approved',
        'sort_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = ['stars'];

    /**
     * Scope: only featured testimonials
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: only approved testimonials
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope: order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    /**
     * Generate star rating display
     */
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating).str_repeat('☆', 5 - $this->rating);
    }
}
