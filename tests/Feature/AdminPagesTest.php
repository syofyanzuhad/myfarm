<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create roles
    \Spatie\Permission\Models\Role::create(['name' => 'admin']);
    \Spatie\Permission\Models\Role::create(['name' => 'peternak']);
    \Spatie\Permission\Models\Role::create(['name' => 'petugas']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});

it('redirects unauthenticated users to login', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

it('allows authenticated admin to access dashboard', function () {
    $this->actingAs($this->admin)
        ->get('/admin')
        ->assertSuccessful();
});

it('allows admin to access animals page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/animals')
        ->assertSuccessful();
});

it('allows admin to access animals create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/animals/create')
        ->assertSuccessful();
});

it('allows admin to access cages page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/cages')
        ->assertSuccessful();
});

it('allows admin to access cages create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/cages/create')
        ->assertSuccessful();
});

it('allows admin to access egg productions page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/egg-productions')
        ->assertSuccessful();
});

it('allows admin to access egg productions create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/egg-productions/create')
        ->assertSuccessful();
});

it('allows admin to access farmers page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/farmers')
        ->assertSuccessful();
});

it('allows admin to access farmers create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/farmers/create')
        ->assertSuccessful();
});

it('allows admin to access feed records page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/feed-records')
        ->assertSuccessful();
});

it('allows admin to access feed records create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/feed-records/create')
        ->assertSuccessful();
});

it('allows admin to access health records page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/health-records')
        ->assertSuccessful();
});

it('allows admin to access health records create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/health-records/create')
        ->assertSuccessful();
});

it('allows admin to access users page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/users')
        ->assertSuccessful();
});

it('allows admin to access users create page', function () {
    $this->actingAs($this->admin)
        ->get('/admin/users/create')
        ->assertSuccessful();
});

it('allows admin to access egg production report', function () {
    $this->actingAs($this->admin)
        ->get('/admin/egg-production-report')
        ->assertSuccessful();
});

it('allows admin to access feed report', function () {
    $this->actingAs($this->admin)
        ->get('/admin/feed-report')
        ->assertSuccessful();
});

it('allows admin to access health report', function () {
    $this->actingAs($this->admin)
        ->get('/admin/health-report')
        ->assertSuccessful();
});
