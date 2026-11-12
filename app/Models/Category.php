<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use GeneratesSlug;
    protected $fillable = ['name'];

    public function slugSource(): string
    {
        return 'name';
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
