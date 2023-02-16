<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Building;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $building = Building::whereTranslation('name', 'برج التواب')->first();

        $this->seedApartments(19, 2, $building);

        $building = Building::whereTranslation('name', 'برج حنين')->first();

        $this->seedApartments(19, 2, $building);
    }

    public function seedApartments($floors, $countPerFloor, $building)
    {
        $lastApartmentNumber = 0;
        foreach (range(1, $floors) as $floor) {
            Apartment::factory()->count($countPerFloor)->sequence(
                [
                    'number' => $lastApartmentNumber + 1,
                    'floor' => $floor,
                    'building_id' => $building->id,
                ],
                [
                    'number' => $lastApartmentNumber + 2,
                    'floor' => $floor,
                    'building_id' => $building->id,
                ],
                [
                    'number' => $lastApartmentNumber + 3,
                    'floor' => $floor,
                    'building_id' => $building->id,
                ],
                [
                    'number' => $lastApartmentNumber + 4,
                    'floor' => $floor,
                    'building_id' => $building->id,
                ],
            )->create();

            $lastApartmentNumber = $lastApartmentNumber + 2;
        }
    }
}
