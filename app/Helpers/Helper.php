<?php

namespace App\Helpers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Alert;
use Illuminate\Pagination\LengthAwarePaginator;

class Helper
{
    public static function check_and_make_dir($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    public static function env_update($old, $new)
    {
        $path = base_path('.env');
        $content = file_get_contents($path);
        if (file_exists($path)) {
            file_put_contents($path, str_replace($old, $new, $content));
        }
    }

    public static function str_random($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }


    public static function paginate($items, $perPage = 12, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public static function alert($class, $status, $message)
    {
        $result = Alert::$class($status, $message);
        return $result;
    }

    public static function toast($message, $status)
    {
        $result = Alert::toast($message, $status);
        return $result;
    }

    public static function pure_slug($slug)
    {
        $result = explode('-', $slug);
        array_pop($result);
        return implode('-', $result);
    }

    public static function code_slug($slug)
    {
        $result = explode('-', $slug);
        // dd($result);
        return last($result);
    }

    public static function get_inital($string)
    {
        $initial = "";
        foreach (explode(' ', $string) as $str) {
            $initial .= strtoupper(substr($str, 0, 1));
        }
        return $initial;
    }
}
