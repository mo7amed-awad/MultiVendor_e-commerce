<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Mohamed Awad',
            'email'=>'admin@admin.com',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'01014940640',
        ]);

        DB::table('users')->insert([
            'name'=>'Mohamed Awad2',
            'email'=>'admin2@admin.com',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'01501216464',
        ]);
    }
}
