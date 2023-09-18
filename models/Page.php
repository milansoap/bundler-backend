<?php
class Page implements JsonSerializable {
    private $id;
    private $user_id;
    private $title;
    /** @var Element[] */
    private array $elements;

    public function __construct($id = null, $user_id = null, $elements = null, $title = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->elements = $elements;
        $this->title = $title;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getUsersId() {
        return $this->user_id;
    }
    public function getElements() {
        return $this->elements;
    }
    public function getTitle() {
        return $this->title;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsersId($user_id) {
        $this->user_id = $user_id;
    }
    public function setElements($elements) {
        $this->elements = $elements;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => $this->user_id,
            'elements' => $this->elements,
        ];
    }
}
