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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class , "seller_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignIdFor(\App\Models\User::class , "buyer_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignIdFor(\App\Models\Order::class , "seller_order_id")->nullable()->constrained("orders")->nullOnDelete();
            $table->foreignIdFor(\App\Models\Order::class , "buyer_order_id")->nullable()->constrained("orders")->nullOnDelete();
            $table->float("amount");
            $table->float("price");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
