<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use GeneratesSlug;
    protected $fillable = ['name', 'slug'];

    public function slugSource(): string
    {
        return 'name';
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
