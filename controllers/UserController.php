<?php
include_once './services/UserService.php';

class UserController {
    private $userService;
    public function __construct() {
        $this->userService = new UserService();
    }

    public function handleRequest($method, $id, $action = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getUserById($id);  // Fetch a single user by ID
                } else {
                    $this->getAllUsers();  // Fetch all users
                }
                break;
            case 'POST':
                $this->createUser();  // Create a new user
                break;
            case 'PUT':
                $this->updateUser($id);  // Update user by ID
                break;
            case 'DELETE':
                // $this->deleteUser($id);  // Delete user by ID
                break;
            default:
                http_response_code(405);  // Method Not Allowed
                echo json_encode(["error" => "Method not allowed"]);
                break;
        }
    }
    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }


    public function getAllUsers() {
        $users = $this->userService->getAllUsers();
        $this->sendJsonResponse($users);
    }

    public function getUserById($id) {
        $users = $this->userService->getUserById($id);
        $this->sendJsonResponse($users);
    }
    public function createUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->userService->createUser($data);
        $this->sendJsonResponse($result);
    }

    public function updateUser($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->userService->updateUser($id, $data);
        $this->sendJsonResponse($result);
    }

    public function deleteUser($id) {
        $result = $this->userService->deleteUser($id);
        $this->sendJsonResponse($result);
    }
}
