<?php

use App\Models\Branch;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            // 'branch_id' => Branch::first()->id,
            'name' => 'admin name',
            'type' => 'admin',
            'phone' => '01152059120',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456789')
        ]);
    }
}
