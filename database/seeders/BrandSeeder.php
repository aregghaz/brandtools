<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::truncate();
        $roles = ['Makita', 'Lg', 'Samsung', "Reco"];
        foreach ($roles as $role) {
            $brand = new Brand();
            $brand->title = $role;
            $brand->save();
        }

    }
}
