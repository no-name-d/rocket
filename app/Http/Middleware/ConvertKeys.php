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
        // Получаем GET-переменные
        $query = $request->query();

        // Преобразуем ключи

        $convertedKeys = array_map(
            fn ($key) => str_replace('_', ' ', $key),
            array_keys($query)
        );

        $values = array_values($query);

        $convertedValues = [];

        foreach ($values as $value) {
            $convertedValues[] = array_combine(
                array_map(
                    fn ($key) => str_replace('_', ' ', $key),
                    array_keys($value)
                ),
                array_map(
                    fn ($value) => str_replace('_', ' ', $value),
                    array_values($value)
                )
            );
        }

        $convertedQuery = array_combine(
              $convertedKeys,
            $convertedValues
        );

        //dd($convertedQuery);

        $request->replace($convertedQuery);

        // Меняем запрос
        //$request->replaceQuery($convertedQuery);

        return $next($request);
    }
}
