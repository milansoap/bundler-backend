<?php

namespace Router;

use DTO\RequestApiDTO; // Importing the RequestApiDTO
use DTO\Auth\LoginRequestDTO;
use UserController;
use AuthController;
use ElementController;
use PageController;
use LogController;
use GenerateController;

class Router {
    public function route(RequestApiDTO $requestDTO) {
        $endpoint = $requestDTO->endpoint;
        $id = $requestDTO->id;
        $action = $requestDTO->action;
        $userController = new UserController();
        $authController = new AuthController();
        $elementController = new ElementController();
        $pageController = new PageController();
        $logController = new LogController();
        $generateController = new GenerateController();



        switch ($endpoint) {
            case 'users':
                $userController->handleUsersRequest($requestDTO->method, $id);
                break;
            case 'elements':
                $elementController->handleElementRequest($requestDTO->method, $id);
                break;
            case 'pages':
                $pageController->handlePageRequest($requestDTO->method, $id);
                break;
            case 'login':
                $authController->login();
                break;
            case 'register':
                $authController->register();
                break;
            case 'logs':
                $logController->handleLogRequest($requestDTO->method, $id);
                break;
            case 'generate':
                $generateController->generatePage($id);
                break;
            default:
                http_response_code(404);
                echo json_encode(["error" => "Invalid API endpoint"]);
                break;
        }
    }
}
