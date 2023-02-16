<?php

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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->decimal('amount');
            $table->timestamps();
        });
        Schema::table('installments', function (Blueprint $table) {
            $table->foreignId('transaction_detail_id')
                ->nullable()
                ->constrained('transaction_details')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('transaction_detail_id');
        });
        Schema::dropIfExists('transaction_details');
    }
};
