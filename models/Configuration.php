<?php

class Configuration implements JsonSerializable {
    private $id;
    private $text_color;
    private $background_color;
    private $border_color;
    private $font_size;
    private $font_family;
    private $content;

    public function __construct($id = null, $text_color = null, $background_color = null, $border_color = null, $font_size = null, $font_family = null, $content = null) {
        $this->id = $id;
        $this->text_color = $text_color;
        $this->background_color = $background_color;
        $this->border_color = $border_color;
        $this->font_size = $font_size;
        $this->font_family = $font_family;
        $this->content = $content;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getTextColor() {
        return $this->text_color;
    }
    public function getBackgroundColor() {
        return $this->background_color;
    }
    public function getBorderColor() {
        return $this->border_color;
    }
    public function getFontSize() {
        return $this->font_size;
    }
    public function getFontFamily() {
        return $this->font_family;
    }
    public function getContent() {
        return $this->content;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setTextColor($text_color) {
        $this->text_color = $text_color;
    }
    public function setBackgroundColor($background_color) {
        $this->background_color = $background_color;
    }
    public function setBorderColor($border_color) {
        $this->border_color = $border_color;
    }
    public function setFontSize($font_size) {
        $this->font_size = $font_size;
    }
    public function setFontFamily($font_family) {
        $this->font_family = $font_family;
    }
    public function setContent($content) {
        $this->content = $content;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'text_color' => $this->text_color,
            'background_color' => $this->background_color,
            'border_color' => $this->border_color,
            'font_size' => $this->font_size,
            'font_family' => $this->font_family,
            'content' => $this->content,
        ];
    }
}
