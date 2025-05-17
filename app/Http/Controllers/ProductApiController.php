<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = request('properties');

        if (!$filters) {}

        $properties = array_map(fn($prop) => str_replace('_', ' ', $prop), array_keys($filters));
        $values = array_map(fn($prop) => str_replace('_', ' ', $prop), array_values($filters));
        //dd($properties);

        $products = Product::whereHas('propertyValues', function ($query) use ($properties, $values) {
            $query->whereIn('value', $values)
                ->whereHas('property', function ($subQuery) use ($properties) {
                    $subQuery->whereIn('name', $properties);
                });
        })
            ->get();

        return response()->json($products);

        //dd(request(['properties']));
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
