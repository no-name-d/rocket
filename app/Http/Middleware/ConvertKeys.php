<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertKeys
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // GET query
        $query = $request->query();

        // Converting the request keys
        $convertedKeys = array_map(
            fn($key) => str_replace('_', ' ', $key),
            array_keys($query)
        );

        // Converting the request values
        $values = array_values($query);

        $convertedValues = [];

        // For each value
        foreach ($values as $value) {
            // if value is composite ([])
            if (is_array($value)) {
                $convertedValues[] = array_combine(
                    array_map(
                        fn($key) => str_replace('_', ' ', $key),
                        array_keys($value)
                    ),
                    array_map(
                        fn($value) => str_replace('_', ' ', $value),
                        array_values($value)
                    )
                );
            } else {
                // if value is just simple str
                $convertedValues[] = str_replace('_', ' ', $value);
            }
        }

        // combine converted keys and values
        $convertedQuery = array_combine(
              $convertedKeys,
            $convertedValues
        );

        // replace request query and return request
        $request->replace($convertedQuery);
        return $next($request);
    }
}
