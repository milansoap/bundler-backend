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
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_custom = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $elements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $configQuery = "SELECT * FROM configurations WHERE id = :configuration_id";
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
                    $configRow['content'],
                    $configRow['element_type'],
                    $configRow['margin'],
                    $configRow['padding'],
                    $configRow['border_width'],
                    $configRow['border_style'],
                    $configRow['border_radius']
                );
            } else {
                $configuration = null; // or a new Configuration with default values
            }

            $element = new Element($row['id'], $row['type'], $row['name'], $row['is_custom'], $configuration, $row['page_id']);
            array_push($elements, $element);
        }
        return $elements;
    }

    public function getAllCustomElements(): array {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_custom = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $elements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $configQuery = "SELECT * FROM configurations WHERE id = :configuration_id";
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
                    $configRow['content'],
                    $configRow['element_type'],
                    $configRow['margin'],
                    $configRow['padding'],
                    $configRow['border_width'],
                    $configRow['border_style'],
                    $configRow['border_radius']
                );
            } else {
                $configuration = null; // or a new Configuration with default values
            }

            $element = new Element($row['id'], $row['type'], $row['name'], $row['is_custom'], $configuration, $row['page_id']);
            array_push($elements, $element);
        }
        return $elements;
    }


    public function getAllElementsByPageId($page_id): array {
        $query = "SELECT * FROM " . $this->table_name . " WHERE page_id = :page_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $stmt->execute();

        $elements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $configQuery = "SELECT * FROM configurations WHERE id = :configuration_id";
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
                    $configRow['content'],
                    $configRow['element_type'],
                    $configRow['margin'],
                    $configRow['padding'],
                    $configRow['border_width'],
                    $configRow['border_style'],
                    $configRow['border_radius']
                );
            } else {
                $configuration = null; // or a new Configuration with default values
            }

            $element = new Element($row['id'], $row['type'], $row['name'], $row['is_custom'], $configuration, $row['page_id']);
            array_push($elements, $element);
        }
        return $elements;
    }

    public function updateElement(Element $element): bool {
        try {
            $elementQuery = "UPDATE " . $this->table_name . "
                             SET type = :type, name = :name, is_custom = :is_custom, page_id = :page_id
                             WHERE id = :id";

            $elementStmt = $this->db->prepare($elementQuery);
            $elementStmt->bindParam(':type', $element->getType());
            $elementStmt->bindParam(':name', $element->getName());
            $elementStmt->bindParam(':is_custom', $element->getIsCustom(), PDO::PARAM_INT);
            $elementStmt->bindParam(':page_id', $element->getPageId(), PDO::PARAM_INT);
            $elementStmt->bindParam(':id', $element->getId(), PDO::PARAM_INT);
            $elementStmt->execute();

            $configQuery = "UPDATE configurations SET text_color = :text_color, background_color = :background_color, ... WHERE id = :configuration_id";
            $configStmt = $this->db->prepare($configQuery);
            $configStmt->execute((array) $element->getConfiguration());



            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



    public function createElement(Element $element): bool {
        try {
            // Insert the element's basic attributes
            $elementQuery = "INSERT INTO " . $this->table_name . " (type, name, is_custom, page_id)
                             VALUES (:type, :name, :is_custom, :page_id)";

            $elementStmt = $this->db->prepare($elementQuery);
            $elementStmt->bindParam(':type', $element->getType());
            $elementStmt->bindParam(':name', $element->getName());
            $elementStmt->bindParam(':is_custom', $element->getIsCustom(), PDO::PARAM_INT);
            $elementStmt->bindParam(':page_id', $element->getPageId(), PDO::PARAM_INT);

            $elementStmt->execute();

            $elementId = $this->db->lastInsertId(); // Get the last inserted element ID

            // Insert related configuration attributes
            $config = $element->getConfiguration();
            $configQuery = "INSERT INTO configurations (text_color, background_color, ...) VALUES (:text_color, :background_color, ...)";
            $configStmt = $this->db->prepare($configQuery);
            $configStmt->execute((array) $element->getConfiguration());

            // Add other bindParam statements for other configuration attributes

            $configStmt->execute();

            $configId = $this->db->lastInsertId(); // Get the last inserted configuration ID

            // Update the element with the configuration ID
            $updateElementQuery = "UPDATE " . $this->table_name . " SET configuration_id = :config_id WHERE id = :id";
            $updateElementStmt = $this->db->prepare($updateElementQuery);
            $updateElementStmt->bindParam(':config_id', $configId, PDO::PARAM_INT);
            $updateElementStmt->bindParam(':id', $elementId, PDO::PARAM_INT);

            $updateElementStmt->execute();

            return true;
        } catch (PDOException $e) {
            // Handle exception
            return false;
        }
    }
}
