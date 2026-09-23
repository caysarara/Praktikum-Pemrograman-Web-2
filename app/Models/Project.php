<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'stack',
    ];

    protected $casts = [
        'stack' => 'array',
    ];
}
