<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/post/projects')->assertRedirect('/login');
        $this->get('/post/profile-saya')->assertRedirect('/login');
    }

    public function test_public_pages_stay_open_for_guest(): void
    {
        $this->get('/')->assertOk();
        $this->get('/about')->assertOk();
        $this->get('/education')->assertOk();
        $this->get('/login')->assertOk();
    }

    public function test_non_admin_gets_403_on_project_management(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get('/post/projects')->assertForbidden();
        $this->actingAs($user)->get('/post/projects/create')->assertForbidden();
        $this->actingAs($user)->post('/post/projects', [])->assertForbidden();
    }

    public function test_admin_can_open_project_management(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/post/projects')->assertOk();
        $this->actingAs($admin)->get('/post/projects/trash')->assertOk();
    }

    public function test_profile_saya_is_available_for_any_logged_in_user(): void
    {
        $user = User::factory()->create(['name' => 'Budi Santoso', 'role' => 'user']);

        $this->actingAs($user)
            ->get('/post/profile-saya')
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee($user->email);
    }

    public function test_navbar_shows_logged_in_user_name(): void
    {
        $user = User::factory()->create(['name' => 'Budi Santoso']);

        $this->actingAs($user)->get('/')->assertSee('Halo, Budi Santoso');
        auth()->logout();
        $this->get('/')->assertDontSee('Halo, Budi Santoso');
    }

    public function test_admin_login_goes_to_projects_and_user_login_to_profile_saya(): void
    {
        $admin = User::factory()->admin()->create();
        $this->post('/login', ['email' => $admin->email, 'password' => 'password'])
            ->assertRedirect('/post/projects');
        $this->post('/logout');

        $user = User::factory()->create();
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/post/profile-saya');
    }

    public function test_wrong_password_shows_error_and_stays_guest(): void
    {
        $user = User::factory()->create();

        $this->from('/login')
            ->post('/login', ['email' => $user->email, 'password' => 'salah'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_closes_post_area_again(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->get('/post/projects')->assertRedirect('/login');
    }
}
