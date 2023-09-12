<?php

namespace Router;

require_once './autoloader.php'; // Include your autoloader

use UserController;

class RequestHandler {
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
}
