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
        Schema::table('deals', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('description');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('bogo_buy_quantity')->nullable()->after('discount_value');
            $table->integer('bogo_get_quantity')->nullable()->after('bogo_buy_quantity');
            $table->string('bogo_product')->nullable()->after('bogo_get_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'bogo_buy_quantity', 'bogo_get_quantity', 'bogo_product']);
        });
    }
};
