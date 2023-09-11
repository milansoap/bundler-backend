<?php

namespace DTO;

class RequestApiDTO {
    public $method;
    public $endpoint;
    public $id;
    public $action;

    public function __construct($method, $endpoint, $id, $action) {
        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->id = $id;
        $this->action = $action;
    }
}
