<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $override = []): array
    {
        return array_merge([
            'nama'      => 'Dungeon Battle',
            'deskripsi' => 'Game RPG sederhana berbasis Java Swing.',
            'stack'     => 'Java, Java Swing',
            'status'    => 'published',
        ], $override);
    }

    private function makeProject(array $override = []): Project
{
    return Project::create(array_merge(
        $this->payload(),
        ['stack' => ['Java', 'Java Swing']],   // array, sesuai cast model
        $override
    ));
}

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_index_lists_projects_with_search_and_filter(): void
    {
        Project::create($this->payload(['nama' => 'Alpha Project']));
        Project::create($this->payload(['nama' => 'Beta Draft', 'status' => 'draft']));

        $this->get('/post/projects')->assertOk()->assertSee('Alpha Project')->assertSee('Beta Draft');
        $this->get('/post/projects?status=published')->assertSee('Alpha Project')->assertDontSee('Beta Draft');
        $this->get('/post/projects?search=Beta')->assertSee('Beta Draft')->assertDontSee('Alpha Project');
    }

    public function test_create_form_and_store(): void
    {
        $this->get('/post/projects/create')->assertOk();

        $this->post('/post/projects', $this->payload())
            ->assertRedirect(route('projects.index'))
            ->assertSessionHas('success');

        $project = Project::firstWhere('nama', 'Dungeon Battle');
        $this->assertNotNull($project);
        $this->assertSame(['Java', 'Java Swing'], $project->stack);
    }

    public function test_store_validates_input(): void
    {
        $this->post('/post/projects', ['nama' => 'abc', 'deskripsi' => 'pendek', 'status' => 'x'])
            ->assertSessionHasErrors(['nama', 'deskripsi', 'status']);
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_show_edit_and_update(): void
    {
        $project = Project::create($this->payload());

        $this->get("/post/projects/{$project->id}")->assertOk()->assertSee('Dungeon Battle');
        $this->get("/post/projects/{$project->id}/edit")->assertOk();

        $this->put("/post/projects/{$project->id}", $this->payload(['nama' => 'Nama Baru', 'status' => 'draft']))
            ->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'nama' => 'Nama Baru', 'status' => 'draft']);
    }

    public function test_delete_restore_and_force_delete(): void
    {
        $project = Project::create($this->payload());

        $this->delete("/post/projects/{$project->id}")->assertRedirect(route('projects.index'));
        $this->assertSoftDeleted('projects', ['id' => $project->id]);

        $this->get('/post/projects/trash')->assertOk()->assertSee('Dungeon Battle');

        $this->patch("/post/projects/{$project->id}/restore")->assertRedirect(route('projects.trash'));
        $this->assertNotSoftDeleted('projects', ['id' => $project->id]);

        $this->delete("/post/projects/{$project->id}");
        $this->delete("/post/projects/{$project->id}/force-delete")->assertRedirect(route('projects.trash'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
