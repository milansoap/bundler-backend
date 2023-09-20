<?php
include_once './models/Log.php';
include_once './config/Database.php';


class LogService {
    private $db;
    private $table_name = "logs";

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getLogsByPageId($page_id) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE page_id = :page_id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":page_id", $page_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $logs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($logs, $row);
            }
            return $logs;
        } else {
            // Debug: Log any errors
            error_log("Query failed.");
            return [];
        }
    }
}
