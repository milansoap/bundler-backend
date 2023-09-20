<?php

include_once './services/LogService.php';

class LogController {

    private $logService;

    public function __construct() {
        $this->logService = new LogService();
    }

    public function handleLogRequest(string $method, ?string $id): void {
        $uri = $_SERVER['REQUEST_URI'];
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getLogsByPageId($id);
                }

                // case 'POST':
                //     $elementController->createUser();
                //     break;
                // case 'PUT':
                //     if ($id) {
                //         $elementController->updateUser($id);
                //     }
                //     break;

                // case 'DELETE':
                //     if ($id) {
                //         $elementController->deleteUser($id);
                //     }
                //     break;
        }
    }

    public function getLogsByPageId($id) {
        $logs = $this->logService->getLogsByPageId($id);
        $this->sendJsonResponse($logs);
    }

    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
