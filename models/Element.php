<?php
class Element implements JsonSerializable {
    private $id;
    private $type;
    private $name;
    private $is_custom;
    private ?Configuration $configuration;
    // /** @var Element[] */
    // private array $children_elements;
    private $page_id;

    public function __construct(
        $id = null,
        $type = null,
        $name = null,
        $is_custom = null,
        $configuration = null,
        $page_id = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->is_custom = $is_custom;

        if (is_array($configuration)) {
            $this->configuration = new Configuration($configuration);
        } else {
            $this->configuration = $configuration;
        }

        $this->page_id = $page_id;
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
    // public function getChildrenElements() {
    //     return $this->children_elements;
    // }
    public function getPageId() {
        return $this->page_id;
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
    // public function setChildrenElements($children_elements) {
    //     $this->children_elements = $children_elements;
    // }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'is_custom' => $this->is_custom,
            'configuration' => $this->configuration ? $this->configuration->jsonSerialize() : null,
            // 'children_elements' => $this->children_elements,
            'page_id' => $this->page_id,
        ];
    }
}
