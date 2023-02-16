<?php

use App\Models\Building;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        \App\Models\Wallet::query()->whereNull('model_type')->delete();

        Building::all()->each(function (Building $building) {
            $building->owner->wallet->update(['name' => 'صندوق المالك']);
            $building->wallet->update(['name' => 'صندوق البناية']);
            $building->wallets()->create(['name' => 'صندوق شركة الادارة']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });
    }
};
