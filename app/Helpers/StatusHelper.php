<?php

namespace App\Helpers;

class StatusHelper
{
    public static function agendas($status)
    {
        switch ($status) {
            case 1:
                return [
                    'message' => 'Diterima',
                    'class' => 'success',
                ];
                break;
            case 2:
                return [
                    'message' => 'Pending',
                    'class' => 'warning',
                ];
                break;
            case 3:
                return [
                    'message' => 'Ditolak',
                    'class' => 'danger',
                ];
                break;
            default:
                return [
                    'message' => 'Tidak diketahui',
                    'class' => 'append',
                ];
                break;
        }
    }

    public static function status($status)
    {
        switch ($status) {
            case 1:
                return [
                    'message' => 'Aktif',
                    'class' => 'success',
                ];
                break;
            case 2:
                return [
                    'message' => 'Tidak Aktif',
                    'class' => 'danger',
                ];
                break;
            default:
                return [
                    'message' => 'Tidak diketahui',
                    'class' => 'warning',
                ];
                break;
        }
    }

    public static function semester($param)
    {
        switch ($param) {
            case 1:
                return 'Ganjil';
                break;
            case 2:
                return 'Genap';
                break;

            default:
                return 'Error';
                break;
        }
    }
}
