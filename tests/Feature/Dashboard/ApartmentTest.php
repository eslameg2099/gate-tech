<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Apartment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Astrotomic\Translatable\Validation\RuleFactory;

class ApartmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_apartments()
    {
        $this->actingAsAdmin();

        Apartment::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.apartments.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_apartment_details()
    {
        $this->actingAsAdmin();

        $apartment = Apartment::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.apartments.show', $apartment))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_apartments_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.apartments.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_apartment()
    {
        $this->actingAsAdmin();

        $apartmentsCount = Apartment::count();

        $response = $this->post(
            route('dashboard.apartments.store'),
            Apartment::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $response->assertRedirect();

        $apartment = Apartment::all()->last();

        $this->assertEquals(Apartment::count(), $apartmentsCount + 1);

        $this->assertEquals($apartment->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_apartments_edit_form()
    {
        $this->actingAsAdmin();

        $apartment = Apartment::factory()->create();

        $this->get(route('dashboard.apartments.edit', $apartment))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_apartment()
    {
        $this->actingAsAdmin();

        $apartment = Apartment::factory()->create();

        $response = $this->put(
            route('dashboard.apartments.update', $apartment),
            Apartment::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $apartment->refresh();

        $response->assertRedirect();

        $this->assertEquals($apartment->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_apartment()
    {
        $this->actingAsAdmin();

        $apartment = Apartment::factory()->create();

        $apartmentsCount = Apartment::count();

        $response = $this->delete(route('dashboard.apartments.destroy', $apartment));

        $response->assertRedirect();

        $this->assertEquals(Apartment::count(), $apartmentsCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_apartments()
    {
        if (! $this->useSoftDeletes($model = Apartment::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Apartment::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.apartments.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_apartment_details()
    {
        if (! $this->useSoftDeletes($model = Apartment::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $apartment = Apartment::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.apartments.trashed.show', $apartment));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_apartment()
    {
        if (! $this->useSoftDeletes($model = Apartment::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $apartment = Apartment::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.apartments.restore', $apartment));

        $response->assertRedirect();

        $this->assertNull($apartment->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_apartment()
    {
        if (! $this->useSoftDeletes($model = Apartment::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $apartment = Apartment::factory()->create(['deleted_at' => now()]);

        $apartmentCount = Apartment::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.apartments.forceDelete', $apartment));

        $response->assertRedirect();

        $this->assertEquals(Apartment::withoutTrashed()->count(), $apartmentCount - 1);
    }

    /** @test */
    public function it_can_filter_apartments_by_name()
    {
        $this->actingAsAdmin();

        Apartment::factory()->create([
            'name' => 'Foo',
        ]);

        Apartment::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.apartments.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('apartments.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
