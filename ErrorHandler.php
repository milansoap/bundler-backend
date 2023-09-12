<?php


class ErrorHandler {
    public static function handleError($errno, $errstr, $errfile, $errline) {
        http_response_code(500);
        echo json_encode([
            "error" => "Server Error",
            "message" => $errstr,
            "file" => $errfile,
            "line" => $errline
        ]);
        exit();
    }

    public static function handleException($exception) {
        http_response_code(500);
        echo json_encode([
            "error" => "Server Error",
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
        exit();
    }
}
