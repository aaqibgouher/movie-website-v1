<?php

namespace App\Utilities;

class Output {
    public static function success($message = "", $data = []) {
        return Output::output(200, $message, $data);
    }

    public static function error($message = "", $data = []) {
        return Output::output(400, $message);
    }

    public static function unauthorize($message = "", $data = []) {
        return Output::output(401, "Please login to continue.");
    }

    public static function output($status = 200, $message = "", $data = []) {
        return response() -> json([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ]);
    }
}