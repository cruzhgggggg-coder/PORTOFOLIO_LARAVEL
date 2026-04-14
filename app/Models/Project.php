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
        'views_count',
        'likes_count',
    ];

    protected $casts = [
        'tags' => 'array',
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
    ];

    protected $appends = ['image'];

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
            if ($project->isDirty('title') && ! $project->isDirty('slug')) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Accessor: return image_url or a default placeholder.
     */
    public function getImageAttribute(): string
    {
        return $this->image_url ?? 'https://picsum.photos/seed/'.$this->id.'/800/600';
    }

    /**
     * Scope: only featured projects.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: most viewed projects.
     */
    public function scopeMostViewed($query, int $limit = 10)
    {
        return $query->orderByDesc('views_count')->limit($limit);
    }

    /**
     * Scope: most liked projects.
     */
    public function scopeMostLiked($query, int $limit = 10)
    {
        return $query->orderByDesc('likes_count')->limit($limit);
    }

    /**
     * Increment view count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Increment like count.
     */
    public function incrementLikes(): void
    {
        $this->increment('likes_count');
    }
}
