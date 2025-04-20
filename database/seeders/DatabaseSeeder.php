<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->insert([
            [
                "name" => "admin",
                "email" => "admin@gmail.com",
                "password" =>Hash::make( "123456"),
            ],
            [
                "name" => "Akbar",
                "email" => "Akbar@gmail.com",
                "password" =>Hash::make( "123456"),
            ],
            [
                "name" => "Reza",
                "email" => "Reza@gmail.com",
                "password" =>Hash::make( "123456"),
            ],
            [
                "name" => "Ahmad",
                "email" => "Ahmadr@gmail.com",
                "password" =>Hash::make( "123456"),
            ]
        ],
        );

        Wallet::query()->insert([
            [
                "user_id" =>1,
                "gold_balance" => 0,
                "currency_balance" =>0,
            ],
            [
                "user_id" =>2,
                "gold_balance" => 10,
                "currency_balance" =>2000000,
            ],
            [
                "user_id" =>3,
                "gold_balance" => 20,
                "currency_balance" =>1000000,
            ],
            [
                "user_id" =>4,
                "gold_balance" => 3,
                "currency_balance" =>4000000,
            ]
        ]);
    }
}
