<?php

namespace Cors;

class Cors {
    public static function allowHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    }
}
