<?php

include_once './services/ElementService.php';

class ElementController {

    private $elementService;

    public function __construct() {
        $this->elementService = new ElementService();
    }

    public function handleElementPageRequest(string $method, ?string $id): void {
        switch ($method) {
            case 'GET':
                error_log($id);
                // No need to check for 'page' here, as you've already separated this logic.
                if (isset($id) && is_numeric($id)) {
                    $pageId = $id;
                    error_log("Extracted Page ID: " . $pageId);
                    $this->getAllElementsByPageId($pageId);
                } else {
                    // Handle error case here
                    error_log("Invalid Page ID");
                }
                break;
        }
    }


    public function handleElementRequest(string $method, ?string $id): void {
        $elementController = new ElementController();
        switch ($method) {
            case 'GET':
                $requestURI = $_SERVER['REQUEST_URI'];
                $remainingPath = substr($requestURI, strpos($requestURI, 'elements/') + 9);

                if (strpos($remainingPath, 'page/') === 0) {
                    $pageId = substr($remainingPath, 5);
                    $this->getAllElementsByPageId($pageId);
                } 
                else if ($id === 'not-custom') {
                    $this->getAllNonCustomElements();
                } elseif (is_numeric($id)) {
                    // $this->getElementById($id);
                } elseif ($id === 'custom') {
                    $this->getAllCustomElements();
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
    public function getAllCustomElements() {
        $elements = $this->elementService->getAllCustomElements();
        $this->sendJsonResponse($elements);
    }
    public function getAllElementsByPageId($pageId) {
        $elements = $this->elementService->getAllElementsByPageId($pageId);
        $this->sendJsonResponse($elements);
    }

    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
