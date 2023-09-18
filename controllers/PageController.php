<?php

include_once './services/PageService.php';

class PageController {

    private $pageService;

    public function __construct() {
        $this->pageService = new PageService();
    }

    public function handlePageRequest(string $method, ?string $id): void {
        $uri = $_SERVER['REQUEST_URI'];
        $pageController = new PageController();
        switch ($method) {
            case 'GET':
                if (strpos($uri, '/pages/user/') !== false) {
                    $segments = explode('/', $uri);
                    $userId = end($segments); // This will return '8'

                    // Logic for /pages/user/{id}
                    $this->getPagesByUserId($userId);
                } else if ($id) {
                    // Logic for /pages/{id}
                    $this->getPageById($id);
                } else {
                    // Logic for /pages
                    $this->getAllPages();
                }

            case 'POST':
                if (strpos($uri, '/pages/save/') !== false) {
                    $segments = explode('/', $uri);
                    $page_id = end($segments); // This will return '8'
                    $this->savePage($page_id);
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

    public function getPageById($id) {
        $page = $this->pageService->getPageById($id);
        $this->sendJsonResponse($page);
    }
    public function getAllPages() {
        $pages = $this->pageService->getAllPages();
        $this->sendJsonResponse($pages);
    }
    public function getPagesByUserId($id) {
        $pages = $this->pageService->getPagesByUserId($id);
        $this->sendJsonResponse($pages);
    }
    public function savePage($pageId) {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->pageService->savePage($data, $pageId);
        $this->sendJsonResponse($result);
    }

    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
