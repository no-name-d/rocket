<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = Product::factory()->count(30)->create();
        $properties = Property::factory()->count(10)->create();

        foreach ($properties->random(5) as $property) {
            foreach ($products->random(20) as $product) {
                PropertyValue::factory()->create([
                   'product_id' => $product->id,
                   'property_id' => $property->id
                ]);
            }
        };
    }
}
