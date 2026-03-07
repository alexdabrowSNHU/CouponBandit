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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('merchant_name')->nullable();
            $table->text('deal_url')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->timestampTz('expires_at')->nullable();

            $table->timestampsTz();

            $table->index('type');
            $table->index(['type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
