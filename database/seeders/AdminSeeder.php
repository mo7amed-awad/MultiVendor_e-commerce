<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name'=>'Mohamed Awad',
            'email'=>'admin@admin.com',
            'username'=>'mohamedawad',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'01014940640',
        ]);

        DB::table('admins')->insert([
            'name'=>'Mohamed Awad2',
            'email'=>'admin2@admin.com',
            'username'=>'mohamedawad2',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'01501216464',
        ]);
    }
}
