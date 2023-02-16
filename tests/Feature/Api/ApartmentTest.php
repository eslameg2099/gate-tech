<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Apartment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApartmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_apartments()
    {
        $this->actingAsAdmin();

        Apartment::factory()->count(2)->create();

        $this->getJson(route('api.apartments.index'))
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
    public function test_apartments_select2_api()
    {
        Apartment::factory()->count(5)->create();

        $response = $this->getJson(route('api.apartments.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.apartments.select', ['selected_id' => 4]))
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
    public function it_can_display_the_apartment_details()
    {
        $this->actingAsAdmin();

        $apartment = Apartment::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.apartments.show', $apartment))
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
