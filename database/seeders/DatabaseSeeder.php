<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Carlos',
            'email'=>'carlos@mail.com',
            'password'=>Hash::make('Abc@1234'),
            'phone'=>'3335554171',
            'card_id'=>'525389232333',
            'day_of_birth'=>Carbon::parse('2000-01-01'),
            'city_id'=>10,
            'role'=>'admin'
        ]);
    }
}
