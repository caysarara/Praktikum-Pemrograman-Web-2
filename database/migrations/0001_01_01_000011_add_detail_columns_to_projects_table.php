<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('nama');
            $table->string('short_description')->nullable()->after('slug');
            $table->date('project_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('project_url')->nullable();
            $table->string('repository_url')->nullable();
        });

        $used = [];
        foreach (DB::table('projects')->whereNull('slug')->orderBy('id')->get(['id', 'nama']) as $row) {
            $base = Str::slug($row->nama) ?: 'project';
            $slug = $base;
            $i = 2;
            while (isset($used[$slug]) || DB::table('projects')->where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $used[$slug] = true;

            DB::table('projects')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'short_description',
                'project_date',
                'is_featured',
                'project_url',
                'repository_url',
            ]);
        });
    }
};
