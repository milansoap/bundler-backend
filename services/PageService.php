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


    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->elementService = new ElementService();
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

    public function savePage($data, $pageId) {
        $oldPages = $this->elementService->getAllElementsByPageId($pageId);

        // foreach ($data as $newElement) {
        //     $exists = false;

        //     // Check if newElement already exists in oldElements
        //     foreach ($oldElements as $oldElement) {
        //       if ($newElement['id'] == $oldElement['id']) {
        //         $exists = true;

        //         $this->elementService->updateElement($newElement);
        //         break;
        //       }
        //     }



        return $data;
    }
}
