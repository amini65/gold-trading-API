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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class ,  "user_id")->constrained()->cascadeOnDelete();
            $table->enum("order_type" , \App\Enums\OrderTypeEnum::getValuesInArray());
            $table->enum("order_status" , \App\Enums\OrderStatusEnum::getValuesInArray())->default(\App\Enums\OrderStatusEnum::OPEN->value);
            $table->float("amount");
            $table->float("price");
            $table->float('commission_rate')->nullable();
            $table->float('commission')->default(0);
            $table->float("remaining_amount");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
