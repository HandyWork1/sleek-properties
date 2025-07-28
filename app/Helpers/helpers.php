<?php

use Illuminate\Support\Str;

if (!function_exists('format_size')) {
    function format_size($value)
    {
        return number_format($value) . ' sqft';
    }
}

if (!function_exists('format_price')) {
    function format_price($value, $currency = 'AED')
    {
        return $currency . ' ' . number_format($value);
    }
}

if (!function_exists('format_date')) {
    function format_date($value)
    {
        return optional($value)->format('d/M/Y');
    }
}

