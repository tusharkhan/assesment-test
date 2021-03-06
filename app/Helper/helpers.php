<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 6/1/2022
 */


use Illuminate\Support\Facades\DB;

if ( ! function_exists('sendResponse') ){
    /**
     * @param $message
     * @param $result
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function sendResponse($message, $result, int $code = 200)
    {
        $response = [
            'code' => $code,
            'success' => true,
            'message' => $message,
            'response_data' => $result,
            'errors' => [],
        ];

        return response()->json($response, $code);
    }
}


if ( ! function_exists('sendError') ){
    /**
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function sendError($error, array $errorMessages = [], int $code = 404)
    {
        $response = [
            'code' => $code,
            'success' => false,
            'message' => $error,
            'response_data' => [],
            'errors' => $errorMessages,
        ];

        return response()->json($response, $code);
    }
}


if ( ! function_exists('insertIntoTable') ){
    /**
     * @param $table
     * @param $data
     * @return bool
     */
    function insertIntoTable($table, $data)
    {
        return DB::table($table)->insert($data);
    }
}
