<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\OrderTypeEnum;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{

    public function test_user_can_create_buy_order()
    {

        $response = $this->postJson('api/order/store', [
            'user_id' => 4,
            'order_type' => 'buy',
            'price' => 100,
            'amount' => 2
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'message',
                'paginate'
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' =>4,
            'order_type' => OrderTypeEnum::BUY->value,
            'price' => 100,
            'amount' => 2
        ]);
    }

    public function test_user_can_create_sell_order()
    {

        $response = $this->postJson('api/order/store', [
            'user_id' => 2,
            'order_type' => 'sell',
            'price' => 100,
            'amount' => 8
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'message',
                'paginate'
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' =>2,
            'order_type' => OrderTypeEnum::BUY->value,
            'price' => 100,
            'amount' => 8
        ]);
    }

    public function test_user_can_cancel_their_order()
    {

        $response = $this->postJson("/api/order/cancelled/2");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'true',
                'message' => 'Order cancelled successfully',
                'order' ,
                'paginate'
            ]);
    }


}
