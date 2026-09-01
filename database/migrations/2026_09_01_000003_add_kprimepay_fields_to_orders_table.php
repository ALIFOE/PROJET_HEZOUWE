<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Trace du paiement Mobile Money : operateur et numero utilises pour le push
     * USSD, date de reglement et origine de la confirmation (KPRIMEPAY ou admin).
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_gateway')->nullable()->after('transaction_id');
            $table->string('payment_phone', 30)->nullable()->after('payment_gateway');
            $table->timestamp('paid_at')->nullable()->after('payment_phone');
            $table->string('payment_confirmed_via', 20)->nullable()->after('paid_at');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_phone',
                'paid_at',
                'payment_confirmed_via',
            ]);
        });
    }
};
