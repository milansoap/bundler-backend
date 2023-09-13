<?php
include_once './models/User.php';
include_once './models/Configuration.php';
include_once './models/Element.php';
include_once './config/Database.php';


class ElementService {
    private $db;
    private $table_name = "elements";

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllNonCustomElements(): array {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_custom = 0";  // Add condition to fetch non-custom elements
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $elements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $configQuery = "SELECT * FROM configurations WHERE id = :configuration_id";  // Match with configuration_id from elements table
            $configStmt = $this->db->prepare($configQuery);
            $configStmt->bindParam(":configuration_id", $row['configuration_id']);
            $configStmt->execute();
            $configRow = $configStmt->fetch(PDO::FETCH_ASSOC);

            if ($configRow) {
                $configuration = new Configuration(
                    $configRow['id'],
                    $configRow['text_color'],
                    $configRow['background_color'],
                    $configRow['border_color'],
                    $configRow['font_size'],
                    $configRow['font_family'],
                    $configRow['content']
                );
            } else {
                $configuration = null;  // or a new Configuration with default values
            }


            $element = new Element($row['id'], $row['type'], $row['name'], $row['is_custom'], $configuration);
            array_push($elements, $element);
        }

        return $elements;
    }
}
