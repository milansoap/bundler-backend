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
    public function createLog($pageId) {
        try {
            $timestamp = date('Y-m-d H:i:s');

            // Get the latest version_id for the page
            $sql = "SELECT MAX(version_id) as latest_version FROM logs WHERE page_id = :page_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $newVersionId = $result ? ($result['latest_version'] + 1) : 1;

            // Insert the new log
            $sql = "INSERT INTO logs (page_id, timestamp, version_id) VALUES (:page_id, :timestamp, :version_id)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
            $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
            $stmt->bindParam(':version_id', $newVersionId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
