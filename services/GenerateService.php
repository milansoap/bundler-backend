<?php


include_once './models/User.php';
include_once './models/Configuration.php';
include_once './models/Element.php';
include_once './config/Database.php';
include_once './services/ElementService.php';


class GenerateService {

    private $db;
    private $table_name = "pages";
    private $elementService;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->elementService = new ElementService();
    }

    public function generatePage($id) {
        $elements = $this->elementService->getAllElementsByPageId($id);

        $jsCode = "document.addEventListener('DOMContentLoaded', function() {";
        foreach ($elements as $element) {
            $config = $element->getConfiguration();
            $jsCode .= "var element = document.createElement('{$config->getElementType()}');";
            $jsCode .= "element.style.color = '{$config->getTextColor()}';";
            $jsCode .= "element.style.backgroundColor = '{$config->getBackgroundColor()}';";
            $jsCode .= "element.style.borderColor = '{$config->getBorderColor()}';";
            $jsCode .= "element.style.margin = '{$config->getMargin()}';";
            $jsCode .= "element.style.padding = '{$config->getPadding()}';";
            $jsCode .= "element.style.borderWidth = '{$config->getBorderWidth()}';";
            $jsCode .= "element.style.borderStyle = '{$config->getBorderStyle()}';";
            $jsCode .= "element.style.borderRadius = '{$config->getBorderRadius()}';";
            $jsCode .= "element.innerHTML = '{$config->getContent()}';";
            $jsCode .= "document.body.appendChild(element);";
        }
        $jsCode .= "});";

        echo "<script>$jsCode</script>";
    }
}
