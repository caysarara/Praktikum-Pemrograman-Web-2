<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $table->primary(['project_id', 'technology_id']);
        });

        $technologies = DB::table('technologies')->pluck('id', 'name')
            ->mapWithKeys(fn ($id, $name) => [mb_strtolower($name) => $id]);

        if ($technologies->isEmpty()) {
            return;
        }

        foreach (DB::table('projects')->whereNotNull('stack')->get(['id', 'stack']) as $project) {
            $names = json_decode($project->stack, true);

            if (! is_array($names)) {
                continue;
            }

            $ids = collect($names)
                ->map(fn ($name) => $technologies->get(mb_strtolower(trim((string) $name))))
                ->filter()
                ->unique()
                ->values();

            foreach ($ids as $technologyId) {
                DB::table('project_technology')->insert([
                    'project_id'    => $project->id,
                    'technology_id' => $technologyId,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
