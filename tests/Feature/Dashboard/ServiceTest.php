<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Astrotomic\Translatable\Validation\RuleFactory;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_services()
    {
        $this->actingAsAdmin();

        Service::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.services.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_service_details()
    {
        $this->actingAsAdmin();

        $service = Service::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.services.show', $service))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_services_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.services.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_service()
    {
        $this->actingAsAdmin();

        $servicesCount = Service::count();

        $response = $this->post(
            route('dashboard.services.store'),
            Service::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $response->assertRedirect();

        $service = Service::all()->last();

        $this->assertEquals(Service::count(), $servicesCount + 1);

        $this->assertEquals($service->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_services_edit_form()
    {
        $this->actingAsAdmin();

        $service = Service::factory()->create();

        $this->get(route('dashboard.services.edit', $service))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_service()
    {
        $this->actingAsAdmin();

        $service = Service::factory()->create();

        $response = $this->put(
            route('dashboard.services.update', $service),
            Service::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $service->refresh();

        $response->assertRedirect();

        $this->assertEquals($service->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_service()
    {
        $this->actingAsAdmin();

        $service = Service::factory()->create();

        $servicesCount = Service::count();

        $response = $this->delete(route('dashboard.services.destroy', $service));

        $response->assertRedirect();

        $this->assertEquals(Service::count(), $servicesCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_services()
    {
        if (! $this->useSoftDeletes($model = Service::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Service::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.services.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_service_details()
    {
        if (! $this->useSoftDeletes($model = Service::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $service = Service::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.services.trashed.show', $service));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_service()
    {
        if (! $this->useSoftDeletes($model = Service::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $service = Service::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.services.restore', $service));

        $response->assertRedirect();

        $this->assertNull($service->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_service()
    {
        if (! $this->useSoftDeletes($model = Service::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $service = Service::factory()->create(['deleted_at' => now()]);

        $serviceCount = Service::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.services.forceDelete', $service));

        $response->assertRedirect();

        $this->assertEquals(Service::withoutTrashed()->count(), $serviceCount - 1);
    }

    /** @test */
    public function it_can_filter_services_by_name()
    {
        $this->actingAsAdmin();

        Service::factory()->create([
            'name' => 'Foo',
        ]);

        Service::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.services.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('services.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
