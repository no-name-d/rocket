<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ProductService
{

    // This method handles filtering products based on given GET-parameters.
    // It takes a filter key (e.g., 'properties') and the entire request array.
    // Depending on the filter type, it calls either 'getByProperties' or returns all products.
    public function filter(?String $key, array $request) : Collection
    {
        return match ($key) {
            'properties' => $this->getByProperties($request[$key]),
            default => $this->getAll()
        };
    }

    //

    /**
     * Recursive function for filtering products by their properties.
     * We divide the array of properties by elements, substituting the property and the array into an ORM-generated
     * SQL query, then save the result and recursively call the same function, making a filter by the id of the previously
     * obtained products, until we go through all the parameters.
     * After that, we return the non-repeating collection of products.
     * @param $properties
     * @param Collection|null $products
     * @return Collection
     */
    private function getByProperties($properties, ?Collection $products = null) : Collection
    {
        // Take the first property-value pair from the input array.
        $currentProperty = array_slice($properties, 0, 1);

        // Extract remaining properties for further recursive processing.
        $otherProperties = array_slice($properties, 1);

        // Flatten values associated with the current property.
        $values = Arr::flatten(array_values($currentProperty));

        // Get the name of the current property.
        $property = array_keys($currentProperty)[0];

        // Prepare IDs of currently filtered products (if any).
        $productsIds = null;
        if ($products) {
            $productsIds = array_column($products->toArray(), 'id');
        }

        // Perform the main filtering operation using joins across related tables.
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

        // Recursively continue filtering if there are other properties left.
        if (count($otherProperties) > 0) {
            $filteredProducts = $this->getByProperties($otherProperties, $filteredProducts);
        }
        // Return unique products to avoid duplicates.
        return $filteredProducts->unique('id')->sortBy('id')->values();
    }

    // Simple method to retrieve all products.
    private function getAll() : ?Collection
    {
        return Product::all(['id', 'name', 'price', 'quant'])->sortBy('id');
    }
}
