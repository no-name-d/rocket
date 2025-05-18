<?php

namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductsFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws \Throwable
     */

    #[Test]
    #[Group('product')]
    public function test_product_filter_with_properties_and_pagination()
    {
        Artisan::call('generate:remigrate-and-create-mock-product');

        // Prepare the test data
        $expectedBrand = 'Россвет';
        $expectedWeights = ['0.5 кг', '1 кг'];

        // Prepare GET-query with param
        $response = $this->get('/products?page=1&properties[Бренд]=' . $expectedBrand . '&properties[Вес][]=' . $expectedWeights[0] . '&properties[Вес][]=' . $expectedWeights[1]);

        // Checking the response status
        $response->assertOk(); // 200 OK
        dump(json_decode($response->getContent(), true));
    }

    #[Test]
    #[Group('product')]
    public function test_product_filter_with_pagination()
    {

        Artisan::call('generate:remigrate-and-create-mock-product');
        // Prepare GET-query with param
        $response = $this->get('/products?page=2');

        // Checking the response status
        $response->assertOk(); // 200 OK
        $response->assertJsonCount(10, 'data');
        dump(json_decode($response->getContent(), true));

    }
}
