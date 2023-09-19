<?php

use function PHPSTORM_META\type;

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

            $element = new Element($row['id'], $row['type'], $row['name'], $row['is_custom'], $configuration, $row['page_id'], $row['unique_element_id']);
            array_push($elements, $element);
        }
        return $elements;
    }

    public function updateElement(Element $element): bool {
        try {
            // print_r(gettype($element));

            // Update the Element table
            $elementQuery = "UPDATE " . $this->table_name . " 
                             SET type = :type, name = :name, is_custom = 1, page_id = :page_id 
                             WHERE id = :id";
            $elementStmt = $this->db->prepare($elementQuery);

            $type = $element->getType();
            $name = $element->getName();
            $is_custom = $element->getIsCustom();
            $page_id = $element->getPageId();
            $id = $element->getId();

            $elementStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $elementStmt->bindParam(':type', $type);
            $elementStmt->bindParam(':name', $name);
            $elementStmt->bindParam(':is_custom', $is_custom, PDO::PARAM_INT);
            $elementStmt->bindParam(':page_id', $page_id, PDO::PARAM_INT);
            $elementStmt->execute();

            // Update the Configurations table
            $configuration = $element->getConfiguration();
            print_r(gettype($configuration));

            if ($configuration !== null) {
                $configQuery = "UPDATE configurations 
                                SET text_color = :text_color, background_color = :background_color, border_color = :border_color,
                                font_size = :font_size, font_family = :font_family, content = :content, element_type = :element_type,
                                margin = :margin, padding = :padding, border_width = :border_width, border_style = :border_style, 
                                border_radius = :border_radius
                                WHERE id = :configuration_id";



                $configStmt = $this->db->prepare($configQuery);

                $configuration_id = $configuration->getId();
                $text_color = $configuration->getTextColor();
                $background_color = $configuration->getBackgroundColor();
                $border_color = $configuration->getBorderColor();
                $font_size = $configuration->getFontSize();
                $font_family = $configuration->getFontFamily();
                $content = $configuration->getContent();
                $element_type = $configuration->getElementType();
                $margin = $configuration->getMargin();
                $padding = $configuration->getPadding();
                $border_width = $configuration->getBorderWidth();
                $border_style = $configuration->getBorderStyle();
                $border_radius = $configuration->getBorderRadius();

                print_r($font_size);

                $configStmt->bindParam(':configuration_id', $configuration_id, PDO::PARAM_INT);
                $configStmt->bindParam(':text_color', $text_color);
                $configStmt->bindParam(':background_color', $background_color);
                $configStmt->bindParam(':border_color', $border_color);
                $configStmt->bindParam(':font_size', $font_size);
                $configStmt->bindParam(':font_family', $font_family);
                $configStmt->bindParam(':content', $content);
                $configStmt->bindParam(':element_type', $element_type);
                $configStmt->bindParam(':margin', $margin);
                $configStmt->bindParam(':padding', $padding);
                $configStmt->bindParam(':border_width', $border_width);
                $configStmt->bindParam(':border_style', $border_style);
                $configStmt->bindParam(':border_radius', $border_radius);


                $configStmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            // Handle exception
            return false;
        }
    }

    public function createElement(Element $element, $pageId): bool {
        try {
            // Insert new Element

            $elementQuery = "INSERT INTO " . $this->table_name . " (type, name, is_custom, page_id, unique_element_id) 
            VALUES (:type, :name, 1, :page_id, :unique_element_id)";
            $elementStmt = $this->db->prepare($elementQuery);

            $type = $element->getType();
            $name = $element->getName();
            $uniqueElementId = $this->generateUniqueId();


            $elementStmt->bindParam(':type', $type);
            $elementStmt->bindParam(':name', $name);
            $elementStmt->bindParam(':page_id', $pageId, PDO::PARAM_INT);
            $elementStmt->bindParam(':unique_element_id', $uniqueElementId);
            $elementStmt->execute();

            $lastElementId = $this->db->lastInsertId();

            // Insert new Configuration
            $configuration = $element->getConfiguration();
            if ($configuration !== null) {
                $configQuery = "INSERT INTO configurations (text_color, background_color, border_color, font_size, font_family, content, element_type, margin, padding, border_width, border_style, border_radius)
                            VALUES (:text_color, :background_color, :border_color, :font_size, :font_family, :content, :element_type, :margin, :padding, :border_width, :border_style, :border_radius)";
                $configStmt = $this->db->prepare($configQuery);

                $text_color = $configuration->getTextColor();
                $background_color = $configuration->getBackgroundColor();
                $border_color = $configuration->getBorderColor();
                $font_size = $configuration->getFontSize();
                $font_family = $configuration->getFontFamily();
                $content = $configuration->getContent();
                $element_type = $configuration->getElementType();
                $margin = $configuration->getMargin();
                $padding = $configuration->getPadding();
                $border_width = $configuration->getBorderWidth();
                $border_style = $configuration->getBorderStyle();
                $border_radius = $configuration->getBorderRadius();

                $configStmt->bindParam(':text_color', $text_color);
                $configStmt->bindParam(':background_color', $background_color);
                $configStmt->bindParam(':border_color', $border_color);
                $configStmt->bindParam(':font_size', $font_size);
                $configStmt->bindParam(':font_family', $font_family);
                $configStmt->bindParam(':content', $content);
                $configStmt->bindParam(':element_type', $element_type);
                $configStmt->bindParam(':margin', $margin);
                $configStmt->bindParam(':padding', $padding);
                $configStmt->bindParam(':border_width', $border_width);
                $configStmt->bindParam(':border_style', $border_style);
                $configStmt->bindParam(':border_radius', $border_radius);

                $configStmt->execute();

                $lastConfigId = $this->db->lastInsertId();

                // Update the Element with this Configuration ID
                $updateElementQuery = "UPDATE " . $this->table_name . " SET configuration_id = :configuration_id WHERE id = :element_id";
                $updateStmt = $this->db->prepare($updateElementQuery);
                $updateStmt->bindParam(':configuration_id', $lastConfigId, PDO::PARAM_INT);
                $updateStmt->bindParam(':element_id', $lastElementId, PDO::PARAM_INT);
                $updateStmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            print_r("Error: " . $e->getMessage());
            return false;
        }
    }

    function generateUniqueId() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
