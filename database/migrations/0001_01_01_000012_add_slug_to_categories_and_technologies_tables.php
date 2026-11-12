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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        foreach (['categories', 'technologies'] as $tableName) {
            $used = [];
            foreach (DB::table($tableName)->whereNull('slug')->orderBy('id')->get(['id', 'name']) as $row) {
                $base = Str::slug($row->name) ?: 'item';
                $slug = $base;
                $i = 2;
                while (isset($used[$slug]) || DB::table($tableName)->where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $used[$slug] = true;

                DB::table($tableName)->where('id', $row->id)->update(['slug' => $slug]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
