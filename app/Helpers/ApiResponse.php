<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = [], $message = 'Success', $status = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error($message = 'Server Error', $status = 500)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
        ], $status);
    }
}
