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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model');
            $table->timestamps();
        });

        \App\Models\Rent::query()->delete();
        \App\Models\Transaction::query()->delete();

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('wallet_id')->after('actor_id')->constrained('wallets')->cascadeOnDelete();
            $table->decimal('balance')->default(0)->after('amount');
            $table->string('check_number')->nullable()->after('payment_method');
            $table->timestamp('date')->after('check_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('wallet_id');
            $table->dropColumn(['balance', 'check_number', 'date']);
        });

        Schema::dropIfExists('wallets');
    }
};
