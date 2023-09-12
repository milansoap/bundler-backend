<?php
class Page implements JsonSerializable {
    private $id;
    private $users_id;
    private $content;

    public function __construct($id = null, $users_id = null, $content = null) {
        $this->id = $id;
        $this->users_id = $users_id;
        $this->content = $content;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getUsersId() {
        return $this->users_id;
    }
    public function getContent() {
        return $this->content;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsersId($users_id) {
        $this->users_id = $users_id;
    }
    public function setContent($content) {
        $this->content = $content;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'users_id' => $this->users_id,
            'content' => $this->content,
        ];
    }
}
