<?php

namespace App\Http;

class MessageAlert
{
    public static function send_success($data = null){
        return response()->json($data, 200);
    }
    public static function send_bad_request($message = "400 Bad Request"){
        return response()->json($message, 400);
    }
    public static function send_unauthorized($message = "401 Unauthorized"){
        return response()->json($message, 401);
    }
    public static function send_forbidden($message = "403 Forbidden"){
        return response()->json($message, 403);
    }
    public static function send_404($message = "404 Not Found"){
        return response()->json($message, 404);
    }
}
