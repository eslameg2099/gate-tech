<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Astrotomic\Translatable\Validation\RuleFactory;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_buildings()
    {
        $this->actingAsAdmin();

        Building::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.buildings.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_building_details()
    {
        $this->actingAsAdmin();

        $building = Building::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.buildings.show', $building))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_buildings_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.buildings.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_building()
    {
        $this->actingAsAdmin();

        $buildingsCount = Building::count();

        $response = $this->post(
            route('dashboard.buildings.store'),
            Building::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $response->assertRedirect();

        $building = Building::all()->last();

        $this->assertEquals(Building::count(), $buildingsCount + 1);

        $this->assertEquals($building->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_buildings_edit_form()
    {
        $this->actingAsAdmin();

        $building = Building::factory()->create();

        $this->get(route('dashboard.buildings.edit', $building))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_building()
    {
        $this->actingAsAdmin();

        $building = Building::factory()->create();

        $response = $this->put(
            route('dashboard.buildings.update', $building),
            Building::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $building->refresh();

        $response->assertRedirect();

        $this->assertEquals($building->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_building()
    {
        $this->actingAsAdmin();

        $building = Building::factory()->create();

        $buildingsCount = Building::count();

        $response = $this->delete(route('dashboard.buildings.destroy', $building));

        $response->assertRedirect();

        $this->assertEquals(Building::count(), $buildingsCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_buildings()
    {
        if (! $this->useSoftDeletes($model = Building::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Building::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.buildings.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_building_details()
    {
        if (! $this->useSoftDeletes($model = Building::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $building = Building::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.buildings.trashed.show', $building));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_building()
    {
        if (! $this->useSoftDeletes($model = Building::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $building = Building::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.buildings.restore', $building));

        $response->assertRedirect();

        $this->assertNull($building->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_building()
    {
        if (! $this->useSoftDeletes($model = Building::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $building = Building::factory()->create(['deleted_at' => now()]);

        $buildingCount = Building::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.buildings.forceDelete', $building));

        $response->assertRedirect();

        $this->assertEquals(Building::withoutTrashed()->count(), $buildingCount - 1);
    }

    /** @test */
    public function it_can_filter_buildings_by_name()
    {
        $this->actingAsAdmin();

        Building::factory()->create([
            'name' => 'Foo',
        ]);

        Building::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.buildings.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('buildings.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
