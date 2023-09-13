<?php
class Element implements JsonSerializable {
    private $id;
    private $type;
    private $name;
    private $is_custom;
    private ?Configuration $configuration;  // Typed property

    public function __construct($id = null, $type = null, $name = null, $is_custom = null, $configuration = null) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->is_custom = $is_custom;
        $this->configuration = $configuration;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getType() {
        return $this->type;
    }
    public function getName() {
        return $this->name;
    }
    public function getIsCustom() {
        return $this->is_custom;
    }
    public function getConfiguration() {
        return $this->configuration;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setType($type) {
        $this->type = $type;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setIsCustom($is_custom) {
        $this->is_custom = $is_custom;
    }
    public function setConfiguration($configuration) {
        $this->configuration = $configuration;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'is_custom' => $this->is_custom,
            'configuration' => $this->configuration ? $this->configuration->jsonSerialize() : null
        ];
    }
}
