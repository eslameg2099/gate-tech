<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Owner;

class OwnerTest extends TestCase
{
    /** @test */
    public function it_can_display_list_of_owners()
    {
        $this->actingAsAdmin();

        Owner::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.owners.index'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_owner_details()
    {
        $this->actingAsAdmin();

        $owner = Owner::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.owners.show', $owner));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_owner_create_form()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.owners.create'));

        $response->assertSuccessful();

        $response->assertSee(trans('owners.actions.create'));
    }

    /** @test */
    public function it_can_create_owners()
    {
        $this->actingAsAdmin();

        $ownersCount = Owner::count();

        $response = $this->postJson(
            route('dashboard.owners.store'),
            Owner::factory()->raw([
                'name' => 'Owner',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
        );

        $response->assertRedirect();

        $this->assertEquals(Owner::count(), $ownersCount + 1);
    }

    /** @test */
    public function it_can_display_owner_edit_form()
    {
        $this->actingAsAdmin();

        $owner = Owner::factory()->create();

        $response = $this->get(route('dashboard.owners.edit', $owner));

        $response->assertSuccessful();

        $response->assertSee(trans('owners.actions.edit'));
    }

    /** @test */
    public function it_can_update_owners()
    {
        $this->actingAsAdmin();

        $owner = Owner::factory()->create();

        $response = $this->put(
            route('dashboard.owners.update', $owner),
            Owner::factory()->raw([
                'name' => 'Owner',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
        );

        $response->assertRedirect();

        $owner->refresh();

        $this->assertEquals($owner->name, 'Owner');
    }

    /** @test */
    public function it_can_delete_owner()
    {
        $this->actingAsAdmin();

        $owner = Owner::factory()->create();

        $ownersCount = Owner::count();

        $response = $this->delete(route('dashboard.owners.destroy', $owner));
        $response->assertRedirect();

        $this->assertEquals(Owner::count(), $ownersCount - 1);
    }
    /** @test */
    public function it_can_display_trashed_owners()
    {
        if (! $this->useSoftDeletes($model = Owner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Owner::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.owners.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_owner_details()
    {
        if (! $this->useSoftDeletes($model = Owner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $owner = Owner::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.owners.trashed.show', $owner));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }
    /** @test */
    public function it_can_restore_deleted_owner()
    {
        if (! $this->useSoftDeletes($model = Owner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $owner = Owner::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.owners.restore', $owner));

        $response->assertRedirect();

        $this->assertNull($owner->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_owner()
    {
        if (! $this->useSoftDeletes($model = Owner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $owner = Owner::factory()->create(['deleted_at' => now()]);

        $ownerCount = Owner::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.owners.forceDelete', $owner));

        $response->assertRedirect();

        $this->assertEquals(Owner::withoutTrashed()->count(), $ownerCount - 1);
    }

    /** @test */
    public function it_can_filter_owners_by_name()
    {
        $this->actingAsAdmin();

        Owner::factory()->create(['name' => 'Ahmed']);

        Owner::factory()->create(['name' => 'Mohamed']);

        $this->get(route('dashboard.owners.index', [
            'name' => 'ahmed',
        ]))
            ->assertSuccessful()
            ->assertSee('Ahmed')
            ->assertDontSee('Mohamed');
    }

    /** @test */
    public function it_can_filter_owners_by_email()
    {
        $this->actingAsAdmin();

        Owner::factory()->create([
            'name' => 'FooBar1',
            'email' => 'user1@demo.com',
        ]);

        Owner::factory()->create([
            'name' => 'FooBar2',
            'email' => 'user2@demo.com',
        ]);

        $this->get(route('dashboard.owners.index', [
            'email' => 'user1@',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }

    /** @test */
    public function it_can_filter_owners_by_phone()
    {
        $this->actingAsAdmin();

        Owner::factory()->create([
            'name' => 'FooBar1',
            'phone' => '123',
        ]);

        Owner::factory()->create([
            'name' => 'FooBar2',
            'email' => '456',
        ]);

        $this->get(route('dashboard.owners.index', [
            'phone' => '123',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }
}
