<?php

namespace Router;

use DTO\RequestApiDTO; // Importing the RequestApiDTO
use UserController;

class Router {
    public function route(RequestApiDTO $requestDTO) {
        $endpoint = $requestDTO->endpoint;
        $id = $requestDTO->id;
        $action = $requestDTO->action;
        $handler = new Handler();


        switch ($endpoint) {
            case 'users':
                $handler->handleUsersRequest($requestDTO->method, $id);
                break;
            default:
                http_response_code(404);
                echo json_encode(["error" => "Invalid API endpoint"]);
                break;
        }
    }
}
