<?php

use DTO\Auth\LoginRequestDTO; // Make sure to include the namespace

include_once './services/AuthService.php';

class AuthController {

    private $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    // public function handleRequest($action) {
    //     switch ($action) {
    //         case 'LOGIN':
    //             $this->login();  // Login
    //             break;
    //         case 'REGISTER':
    //             $this->register();  // Register
    //             break;
    //         default:
    //             http_response_code(405);  // Method Not Allowed
    //             echo json_encode(["error" => "Method not allowed"]);
    //             break;
    //     }
    // }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        $loginRequest = new LoginRequestDTO($data['email'], $data['password']);
        $result = $this->authService->login($loginRequest);
        $this->sendJsonResponse($result);
    }

    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);
        $loginRequest = new LoginRequestDTO($data['email'], $data['password']);
        $result = $this->authService->register($loginRequest);
        $this->sendJsonResponse($result);
    }

    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
