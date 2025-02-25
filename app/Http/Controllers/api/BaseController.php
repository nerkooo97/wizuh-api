<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // success response method
    public function sendResponse($result, $message, $per_page = 10)
    {
        $response = [
            'success' => true,
            'per_page' => $per_page,
            'number'  => count($result),
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    // return error response
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
