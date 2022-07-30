<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Branch::create([
            'name'=> 'الدقى',
            'address' => 'العنوان',
            'phone' => '23191423'
        ]);
    }
}
