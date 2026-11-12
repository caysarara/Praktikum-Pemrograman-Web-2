<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Project extends Model
{
    use SoftDeletes, GeneratesSlug;

    public const MAX_GALLERY_IMAGES = 10;

    protected $fillable = [
        'nama',
        'slug',
        'short_description',
        'deskripsi',
        'stack',
        'status',
        'category_id',
        'thumbnail',
        'project_date',
        'is_featured',
        'project_url',
        'repository_url',
    ];

    protected $casts = [
        'stack' => 'array',
        'project_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function slugSource(): string
    {
        return 'nama';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function technologyNames(): Collection
    {
        if ($this->technologies->isNotEmpty()) {
            return $this->technologies->pluck('name');
        }

        return collect($this->stack ?? []);
    }
}
