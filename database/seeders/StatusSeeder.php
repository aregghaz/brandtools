<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::truncate();
        $roles= ['обработка', 'забронированный', 'подтвержденный', "закончено",'отменен'];
        foreach($roles as $role){
            DB::table('statuses')->insert([
                'title' =>$role,
            ]);
        }
    }
}
