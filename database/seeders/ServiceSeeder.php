<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::factory()->create(['name' => 'صيانة المصعد']);
        Service::factory()->create(['name' => 'صيانة السباكة']);
        Service::factory()->create(['name' => 'صيانة التكييف']);
        Service::factory()->create(['name' => 'مصاريف حارس العمارة']);
    }
}
