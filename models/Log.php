<?php

class Log {
    private $id;
    private $pageId;
    private $timestamp;
    private $versionId;

    public function __construct($id = null, $pageId = null, $timestamp = null, $versionId = null) {
        $this->id = $id;
        $this->pageId = $pageId;
        $this->timestamp = $timestamp;
        $this->versionId = $versionId;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getPageId() {
        return $this->pageId;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getVersionId() {
        return $this->versionId;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setPageId($pageId) {
        $this->pageId = $pageId;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function setVersionId($versionId) {
        $this->versionId = $versionId;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'page_id' => $this->pageId,
            'timestamp' => $this->timestamp,
            'version_id' => $this->versionId
        ];
    }
}
