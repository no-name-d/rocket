<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductPropertyValue;
use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Console\Command;

class FakeCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fake-create-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
         * This command create fake products, properties and propvalues
         *
         *
         *
         */

        // create fake props
        $fakeProperties = Property::factory()->count(7)->sequence(
            ['name' => 'Цвет'],
            ['name' => 'Бренд'],
            ['name' => 'Цвет плафона'],
            ['name' => 'Цвет арматуры'],
            ['name' => 'Вес'],
            ['name' => 'Применение'],
            ['name' => 'Длина']
        )->create();

        // create fake products
        $products = Product::factory()->count(50)->create();

        // create fake props value. Property values must be meaningful, so this not random fills
        $fakePropertyValues = PropertyValue::factory()->count(20)->sequence(
            ['property_id' => $fakeProperties[0]->id, 'value' => 'Зеленый'],
            ['property_id' => $fakeProperties[0]->id, 'value' => 'Синий'],
            ['property_id' => $fakeProperties[0]->id, 'value' => 'Белый'],
            ['property_id' => $fakeProperties[1]->id, 'value' => 'Art Style'],
            ['property_id' => $fakeProperties[1]->id, 'value' => 'Ultra Light'],
            ['property_id' => $fakeProperties[1]->id, 'value' => 'Россвет'],
            ['property_id' => $fakeProperties[2]->id, 'value' => 'Желтый'],
            ['property_id' => $fakeProperties[2]->id, 'value' => 'Синий'],
            ['property_id' => $fakeProperties[3]->id, 'value' => 'Цветной'],
            ['property_id' => $fakeProperties[3]->id, 'value' => 'Белый'],
            ['property_id' => $fakeProperties[4]->id, 'value' => '0.5кг'],
            ['property_id' => $fakeProperties[4]->id, 'value' => '1 кг'],
            ['property_id' => $fakeProperties[4]->id, 'value' => '2 кг'],
            ['property_id' => $fakeProperties[5]->id, 'value' => 'Для дома'],
            ['property_id' => $fakeProperties[5]->id, 'value' => 'Для офиса'],
            ['property_id' => $fakeProperties[5]->id, 'value' => 'Для улицы'],
            ['property_id' => $fakeProperties[6]->id, 'value' => '0.8м'],
            ['property_id' => $fakeProperties[6]->id, 'value' => '1.0м'],
            ['property_id' => $fakeProperties[6]->id, 'value' => '1.2м'],
            ['property_id' => $fakeProperties[6]->id, 'value' => '1.6м']
        )->create();

        for ($i = 0; $i < 200; $i++) {
            ProductPropertyValue::factory()->create([
                'product_id' => $products->random()->id,
                'property_value_id' => $fakePropertyValues->random()->id
            ])->save();
        }
    }

}
