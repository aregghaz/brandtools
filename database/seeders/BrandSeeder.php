<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::truncate();
        $roles= ['Makita', 'Lg', 'Samsung', "Reco"];
        foreach($roles as $role){
            DB::table('brands')->insert([
                'title' =>$role,
            ]);
        }

    }
}
