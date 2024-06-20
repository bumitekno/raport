<?php

if (!function_exists('capitalizeEachWord')) {
    function capitalizeEachWord($string)
    {
        // Capitalize each word
        $string = ucwords(strtolower($string));

        // Handle specific cases for titles
        $string = str_replace(['S.pd', 'S.pd.', 'S.pd.i', 'S.pd.i.'], ['S.Pd', 'S.Pd.', 'S.Pd.I', 'S.Pd.I.'], $string);

        return $string;
    }
}