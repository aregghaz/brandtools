<?php

namespace Database\Seeders;

use App\Models\Teg;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TegSeeder  extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\Teg::factory(10)->create();

        Teg::truncate();
        $roles= ['new', 'hot', 'sell'];
        foreach($roles as $role){
            DB::table('tegs')->insert([
                'title' =>$role,
            ]);
        }
    }
}
