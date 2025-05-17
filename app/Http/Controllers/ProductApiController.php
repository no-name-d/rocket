<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = request()->query();

        $service = new ProductService();
        if (array_key_exists('properties', $filters)) {
            $products = $service->filter('properties', $filters);
        } else {
            $products = $service->filter(null, $filters);
        };

        $currentPage = request()->input('page', 1);

        // Количество записей на странице
        $perPage = 40;

        // Получаем нужную страницу
        $paginatedProducts = $products->forPage($currentPage, $perPage);

        // Создаем объект пагинации
        return new LengthAwarePaginator(
            $paginatedProducts,
            $products->count(), // Всего записей
            $perPage, // Сколько записей на странице
            $currentPage, // Текущая страница
            ['path' => request()->url()] // Путь к текущему маршруту
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
