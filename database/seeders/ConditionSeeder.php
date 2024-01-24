<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Condition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Condition::truncate();
        $roles= ['б/у, хорошее', 'б/у', 'хорошее', "новый"];
        foreach($roles as $role){
            DB::table('conditions')->insert([
                'title' =>$role,
            ]);
        }
    }
}
