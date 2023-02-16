<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_buildings()
    {
        $this->actingAsAdmin();

        Building::factory()->count(2)->create();

        $this->getJson(route('api.buildings.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }

    /** @test */
    public function test_buildings_select2_api()
    {
        Building::factory()->count(5)->create();

        $response = $this->getJson(route('api.buildings.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.buildings.select', ['selected_id' => 4]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 4);

        $this->assertCount(5, $response->json('data'));
    }

    /** @test */
    public function it_can_display_the_building_details()
    {
        $this->actingAsAdmin();

        $building = Building::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.buildings.show', $building))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        $this->assertEquals($response->json('data.name'), 'Foo');
    }
}
