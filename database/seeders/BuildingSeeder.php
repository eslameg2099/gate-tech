<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Supervisor;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::factory()->create([
            'name:ar' => 'برج التواب',
            'name:en' => 'Altawab Building',
        ]);

        Building::factory()->create([
            'name:ar' => 'برج حنين',
            'name:en' => 'Haneen Building',
        ]);

        /** @var Supervisor $supervisor */
        $supervisor = Supervisor::factory()->createOne([
            'name' => 'Supervisor',
            'email' => 'supervisor@demo.com',
            'phone' => '222222222',
            'building_id' => Building::first()->id,
        ]);
        $supervisor->givePermissionTo([
            'manage.debits',
            'manage.credits',
        ]);

    }
}
