<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/*
 * This is API controller (without UI-using) for Product
 */
class ProductApiController extends Controller
{
    const int PER_PAGE = 40;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // We get products collection by filters
        $filters = request()->query();

        if (array_key_exists('properties', $filters)) {
            $products = $this->productService->filter('properties', $filters);
        } else {
            $products = $this->productService->filter(null, $filters);
        };

        // get number of required page from GET key
        $currentPage = request()->input('page', 1);

        // Number of entries per page
        $perPage = self::PER_PAGE;

        // Getting the required page
        $paginatedProducts = $products->forPage($currentPage, $perPage);

        // Create pagination object
        return new LengthAwarePaginator(
            $paginatedProducts,
            $products->count(), // All count
            $perPage,
            $currentPage,
            ['path' => request()->url()] // Path to current url
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
