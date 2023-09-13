<?php

include_once './services/ElementService.php';

class ElementController {

    private $elementService;

    public function __construct() {
        $this->elementService = new ElementService();
    }

    public function handleElementRequest(string $method, ?string $id): void {
        $elementController = new ElementController();
        switch ($method) {
            case 'GET':
                if ($method === 'GET') {
                    if ($id === 'not-custom') {
                        $this->getAllNonCustomElements();
                    } elseif (is_numeric($id)) {
                        // $this->getElementById($id);
                    } else {
                        // Fetch all elements or handle error
                    }
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

    public function getAllNonCustomElements() {
        $elements = $this->elementService->getAllNonCustomElements();
        $this->sendJsonResponse($elements);
    }

    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
