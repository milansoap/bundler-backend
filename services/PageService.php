<?php
include_once './models/Page.php';
include_once './models/Configuration.php';
include_once './models/Element.php';
include_once './config/Database.php';
include_once './services/PageService.php';



class PageService {
    private $db;
    private $table_name = "pages";
    private $elementService;
    private $logService;


    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->elementService = new ElementService();
        $this->logService = new LogService();
    }

    public function getAllPages(): array {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $pages = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($pages, $row);
        }
        return $pages;
    }

    public function getPageById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPagesByUserId($userId) {

        error_log("This is a debug message.");
        error_log($userId);

        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);

        // Debug: Log the userId and query
        error_log("UserID: " . $userId);
        error_log("Query: " . $query);

        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $pages = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($pages, $row);
            }
            return $pages;
        } else {
            // Debug: Log any errors
            error_log("Query failed.");
            return [];
        }
    }
    function generateNewId() {
        return uniqid('element_', true);
    }
    function generateNewConfigId() {
        return uniqid('config_', true);
    }

    public function savePage($data, $pageId) {
        $oldElements = $this->elementService->getAllElementsByPageId($pageId);
        foreach ($data['elements'] as $newElement) {
            $exists = false;  // Reset for each newElement
            foreach ($oldElements as $oldElement) {
                if (is_array($newElement) && is_object($oldElement)) {
                    if ($newElement['unique_element_id'] === $oldElement->getUniqueElementId()) {
                        $exists = true;
                        break;
                    } else {
                        $exists = false;
                    }
                } else {
                    error_log("Mismatched types or unexpected data structures.");
                }
            }
            if ($exists) {
                $exists = true;

                $configurationObject = new Configuration(
                    $newElement['configuration']['id'],
                    $newElement['configuration']['text_color'],
                    $newElement['configuration']['background_color'],
                    $newElement['configuration']['border_color'],
                    $newElement['configuration']['content'],
                    $newElement['configuration']['element_type'],
                    $newElement['configuration']['margin'],
                    $newElement['configuration']['padding'],
                    $newElement['configuration']['border_width'],
                    $newElement['configuration']['border_style'],
                    $newElement['configuration']['border_radius'],
                );
                $elementObject = new Element(
                    $newElement['id'],
                    $newElement['type'],
                    $newElement['name'],
                    $newElement['is_custom'],
                    $configurationObject,
                    $newElement['page_id'],
                    $newElement['unique_element_id']
                );

                $this->elementService->updateElement($elementObject);
            }
            if (!$exists) {

                $configurationObject = new Configuration(
                    $newElement['configuration']['id'] = $this->generateNewConfigId(),
                    $newElement['configuration']['text_color'],
                    $newElement['configuration']['background_color'],
                    $newElement['configuration']['border_color'],
                    $newElement['configuration']['content'],
                    $newElement['configuration']['element_type'],
                    $newElement['configuration']['margin'],
                    $newElement['configuration']['padding'],
                    $newElement['configuration']['border_width'],
                    $newElement['configuration']['border_style'],
                    $newElement['configuration']['border_radius'],
                );
                $elementObject = new Element(
                    $newElement['id'] = $this->generateNewId(),
                    $newElement['type'],
                    $newElement['name'],
                    $newElement['is_custom'] = 1,
                    $configurationObject,
                    $newElement['page_id'],
                    $newElement['unique_element_id']
                );

                $this->elementService->createElement($elementObject, $pageId);
            }
        }
        // $newLog = new Log($pageId, date('Y-m-d H:i:s'));
        $this->logService->createLog($pageId);
    }

    // foreach ($data as $newElement) {
    //     $exists = false;

    //     foreach ($oldElements as $oldElement) {
    //         if (isset($newElement['id']) && isset($oldElement['id']) && $newElement['id'] == $oldElement['id']) {
    //             $exists = true;
    //             $this->elementService->updateElement($newElement);
    //             break;
    //         }
    //     }

    //     if (!$exists) {
    //         $this->elementService->createElement($newElement, $pageId);
    //     }
    // }
    // return $data;


}
