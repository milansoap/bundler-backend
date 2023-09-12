<?php
include_once './services/UserService.php';

class UserController {

    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function handleUsersRequest(string $method, ?string $id): void {
        $userController = new UserController();
        switch ($method) {
            case 'GET':
                if ($id) {
                    $userController->getUserById($id);
                } else {
                    $userController->getAllUsers();
                }
                break;
            case 'POST':
                $userController->createUser();
                break;
            case 'PUT':
                if ($id) {
                    $userController->updateUser($id);
                }
                break;

            case 'DELETE':
                if ($id) {
                    $userController->deleteUser($id);
                }
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
