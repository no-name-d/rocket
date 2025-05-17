<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ProductService
{
    public function filter(?String $key, array $request) : Collection
    {
        return match ($key) {
            'properties' => $this->getByProperties($request[$key]),
            default => $this->getAll()
        };
    }

    private function getByProperties($properties, ?Collection $products = null, $lvl = 0) : Collection
    {
        //dd($properties);
        //$firstKey = array_keys($properties)[0];


        $currentProperty = array_slice($properties, 0, 1);

        $otherProperties = array_slice($properties, 1);

        $values = Arr::flatten(array_values($currentProperty));


        //dd($values);

        $property = array_keys($currentProperty)[0];

        $productsIds = null;

        if ($products) {
            $productsIds = array_column($products->toArray(), 'id');
        }

        $filteredProducts = Product::select(['product.id', 'product.name', 'product.price', 'product.quant'])
            ->join('product_property_value', 'product.id', '=', 'product_property_value.product_id')
            ->join('property_value', function ($join) use ($values) {
                $join->on('product_property_value.property_value_id', '=', 'property_value.id')
                    ->whereIn('property_value.value', $values);
            })
            ->join('property', function ($join) use ($property) {
                $join->on('property_value.property_id', '=', 'property.id')
                    ->where('property.name', '=', $property);
            })->when($productsIds, function ($query, $productsIds) {
                return $query->whereIn('product.id', $productsIds);
            })
            ->get();

        //if ($lvl === 1) {
        //    dd($filteredProducts);
        //};

        $lvl++;

        if (count($otherProperties) > 0) {
            $filteredProducts = $this->getByProperties($otherProperties, $filteredProducts, $lvl);
        }
        return $filteredProducts->unique('id');
    }

    private function getAll() : ?Collection
    {
        return Product::all();
    }
}
