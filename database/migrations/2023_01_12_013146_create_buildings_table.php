<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('floors');
            $table->timestamps();
        });

        Schema::create('building_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id');
            $table->string('name')->nullable();
            $table->string('locale')->index();
            $table->unique(['building_id', 'locale']);
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_translations');
        Schema::dropIfExists('buildings');
    }
}
