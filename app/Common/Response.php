<?php
/**
 * Created by PhpStorm.
 * User: Tolga-Pc
 * Date: 13.08.2017
 * Time: 10:23
 */

namespace App\Common;


class Response
{
    /**
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static function success($data = [], $code = 200){
        return response()->json(['data' => $data], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static function error($message = 'Internal Server Error', $code = 500){
        return response()->json(['message' => $message], $code);
    }
}