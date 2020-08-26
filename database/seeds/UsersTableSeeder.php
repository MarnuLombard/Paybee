<?php

use Illuminate\Database\Seeder;
use PayBee\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Marnu Lombard',
            'email' => 'marnulombard@gmail.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'sender_id' => 778065913,
        ]);
    }
}
