<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class FilterHelper
{
    public static function extract($value)
    {
        $operator = '=';
        if (str_contains($value, '$gt:')) {
            $value = str_replace('$gt:', '', $value);
            $operator = '>';
        } else if (str_contains($value, '$gte:')) {
            $value = str_replace('$gte:', '', $value);
            $operator = '>=';
        } else if (str_contains($value, '$lt:')) {
            $value = str_replace('$lt:', '', $value);
            $operator = '<';
        } else if (str_contains($value, '$lte:')) {
            $value = str_replace('$lte:', '', $value);
            $operator = '<=';
        } else if (str_contains($value, '$eq:')) {
            $value = str_replace('$eq:', '', $value);
            $operator = '=';
        }

        return [
            'value' => $value,
            'operator' => $operator
        ];
    }

    public static function querying(Builder $query, $field, $value)
    {
        $variable = self::extract($value);
        return $query->where($field, $variable['operator'], $variable['value']);
    }
}
