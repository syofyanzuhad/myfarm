<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create roles
    \Spatie\Permission\Models\Role::create(['name' => 'admin']);
    \Spatie\Permission\Models\Role::create(['name' => 'peternak']);
    \Spatie\Permission\Models\Role::create(['name' => 'petugas']);
});

it('shows login page for guests', function () {
    $this->get('/admin/login')
        ->assertSuccessful()
        ->assertSee('Sign in');
});

it('can login with valid credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('admin');

    $this->post('/admin/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect('/admin');

    $this->assertAuthenticatedAs($user);
});

it('cannot login with invalid credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $this->post('/admin/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors();

    $this->assertGuest();
});

it('can logout', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $this->actingAs($user);

    $this->post('/admin/logout')
        ->assertRedirect('/admin/login');

    $this->assertGuest();
});

it('redirects authenticated users away from login page', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $this->actingAs($user)
        ->get('/admin/login')
        ->assertRedirect('/admin');
});
