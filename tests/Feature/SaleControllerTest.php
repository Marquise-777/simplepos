<?php

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can view sales index', function () {
    $shop = Shop::factory()->create(['is_setup_complete' => true]);
    $user = User::factory()->create([
        'shop_id' => $shop->id,
        'role' => 'cashier',
    ]);

    $this->actingAs($user);

    $response = $this->get('/sales');

    $response->assertStatus(200);
    $response->assertViewIs('sales.index');
});

test('authenticated user can view sales create page', function () {
    $shop = Shop::factory()->create(['is_setup_complete' => true]);
    $user = User::factory()->create([
        'shop_id' => $shop->id,
        'role' => 'cashier',
    ]);

    $this->actingAs($user);

    $response = $this->get('/sales/create');

    $response->assertStatus(200);
    $response->assertViewIs('sales.create');
});
