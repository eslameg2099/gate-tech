<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(BuildingSeeder::class);
        $this->call(ApartmentSeeder::class);
        $this->call(ServiceSeeder::class);
        /*  The seeders of generated crud will set here: Don't remove this line  */
    }
}
