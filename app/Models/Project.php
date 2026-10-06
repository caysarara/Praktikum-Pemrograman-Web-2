<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'deskripsi',
        'stack',
        'status',
    ];

    protected $casts = [
        'stack' => 'array',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
