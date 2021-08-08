<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('request_status')->insert([
            'name' => 'New',
        ]);
        DB::table('request_status')->insert([
            'name' => 'Accepted',
        ]);
        DB::table('request_status')->insert([
            'name' => 'Finished',
        ]);
        DB::table('request_status')->insert([
            'name' => 'Cancel',
        ]);
        DB::table('request_status')->insert([
            'name' => 'Returning',
        ]);
    }
}
