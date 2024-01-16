<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $attribute1 = Attribute::create(['name' => 'Price', 'type' => 'range']);
        $attribute2 = Attribute::create(['name' => 'Color', 'type' => 'select']);

        AttributeValue::create(['attribute_id' => $attribute2->id, 'value' => 'Red']);
        AttributeValue::create(['attribute_id' => $attribute2->id, 'value' => 'Blue']);
        AttributeValue::create(['attribute_id' => $attribute2->id, 'value' => 'Green']);
    }
}
