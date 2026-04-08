<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'image_url',
        'tech_stack',
        'tags',
        'year',
        'link_repo',
        'link_demo',
        'is_featured',
    ];

    protected $casts = [
        'tags'       => 'array',
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Auto-generate slug from title on creation.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function (Project $project) {
            if ($project->isDirty('title') && !$project->isDirty('slug')) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Accessor: return image_url or a default placeholder.
     */
    public function getImageAttribute(): string
    {
        return $this->image_url ?? 'https://picsum.photos/seed/' . $this->id . '/800/600';
    }

    /**
     * Scope: only featured projects.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
