<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyValue>
 */
class PropertyValueFactory extends Factory
{
    protected $model = PropertyValue::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        ];
    }
}
