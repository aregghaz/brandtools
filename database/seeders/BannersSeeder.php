<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::truncate();
        $roles = ['new', 'hot',];
        foreach ($roles as $role => $index) {
            $teg = new Banner();
            $teg->image = null;
            $teg->position = $role+1;
            $teg->save();
        }
    }
}
