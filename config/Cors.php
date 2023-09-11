<?php

namespace Router;

class Cors {
    public static function allowHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    }
}
