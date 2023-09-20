<?php


include_once './services/GenerateService.php';

class GenerateController {
    private $generateService;

    public function __construct() {
        $this->generateService = new GenerateService();
    }

    public function generatePage($id) {
        $result = $this->generateService->generatePage($id);
        file_put_contents('generatedScript.php', $result);
    }
}
