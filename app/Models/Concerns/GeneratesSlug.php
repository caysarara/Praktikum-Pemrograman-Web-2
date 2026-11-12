<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


trait GeneratesSlug
{

    abstract public function slugSource(): string;

    public static function bootGeneratesSlug(): void
    {
        static::saving(function ($model) {
            if (blank($model->slug)) {
                $model->slug = $model->makeUniqueSlug((string) $model->{$model->slugSource()});
            }
        });
    }

    protected function makeUniqueSlug(string $value): string
    {
        $base = Str::slug($value) ?: 'item';
        $slug = $base;
        $i = 2;

        while ($this->slugExists($slug)) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        $query = static::query()->where('slug', $slug);

        if (in_array(SoftDeletes::class, class_uses_recursive(static::class), true)) {
            $query->withTrashed();
        }

        if ($this->exists) {
            $query->whereKeyNot($this->getKey());
        }

        return $query->exists();
    }
}
