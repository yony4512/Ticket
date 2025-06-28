<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->nullable()->after('total_price');
            $table->decimal('commission', 10, 2)->nullable()->after('subtotal');
            $table->string('payment_method')->nullable()->after('commission');
            $table->string('billing_name')->nullable()->after('payment_method');
            $table->string('billing_email')->nullable()->after('billing_name');
            $table->text('billing_address')->nullable()->after('billing_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'commission', 
                'payment_method',
                'billing_name',
                'billing_email',
                'billing_address'
            ]);
        });
    }
};
