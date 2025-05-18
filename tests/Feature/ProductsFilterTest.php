<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductsFilterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @throws \Throwable
     */
    public function test_product_filter_with_properties_and_pagination()
    {
        Artisan::call('generate:mock-product-command');

        // Prepare the test data
        $expectedBrand = 'Россвет';
        $expectedWeights = ['0.5 кг', '1 кг'];

        // Prepare GET-query with param
        $response = $this->get('/products?page=1&properties[Бренд]='.$expectedBrand.'&properties[Вес][]='.$expectedWeights[0].'&properties[Вес][]='.$expectedWeights[1]);

        // Checking the response status
        $response->assertOk(); // 200 OK
    }

    public function test_product_filter_with_pagination() {

        Artisan::call('generate:mock-product-command');
        // Prepare GET-query with param
        $response = $this->get('/products?page=2');

        // Checking the response status
        $response->assertOk(); // 200 OK
        $response->assertJsonCount(10, 'data');
    }
}
