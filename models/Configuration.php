<?php

class Configuration implements JsonSerializable {
    private $id;
    private $textColor;
    private $backgroundColor;
    private $borderColor;
    private $fontSize;
    private $fontFamily;
    private $content;
    private $elementType;
    private $margin;
    private $padding;
    private $borderWidth;
    private $borderStyle;
    private $borderRadius;

    public function __construct(
        $id = null,
        $textColor = null,
        $backgroundColor = null,
        $borderColor = null,
        $fontSize = null,
        $fontFamily = null,
        $content = null,
        $elementType = null,
        $margin = null,
        $padding = null,
        $borderWidth = null,
        $borderStyle = null,
        $borderRadius = null,
    ) {
        $this->id = $id;
        $this->textColor = $textColor;
        $this->backgroundColor = $backgroundColor;
        $this->borderColor = $borderColor;
        $this->fontSize = $fontSize;
        $this->fontFamily = $fontFamily;
        $this->content = $content;
        $this->elementType = $elementType;
        $this->margin = $margin;
        $this->padding = $padding;
        $this->borderWidth = $borderWidth;
        $this->borderStyle = $borderStyle;
        $this->borderRadius = $borderRadius;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getTextColor() {
        return $this->textColor;
    }
    public function getBackgroundColor() {
        return $this->backgroundColor;
    }
    public function getBorderColor() {
        return $this->borderColor;
    }
    public function getFontSize() {
        return $this->fontSize;
    }
    public function getFontFamily() {
        return $this->fontFamily;
    }
    public function getContent() {
        return $this->content;
    }
    public function getElementType() {
        return $this->elementType;
    }
    public function getMargin() {
        return $this->margin;
    }
    public function getPadding() {
        return $this->padding;
    }
    public function getBorderWidth() {
        return $this->borderWidth;
    }
    public function getBorderStyle() {
        return $this->borderStyle;
    }
    public function getBorderRadius() {
        return $this->borderRadius;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setTextColor($textColor) {
        $this->textColor = $textColor;
    }
    public function setBackgroundColor($backgroundColor) {
        $this->backgroundColor = $backgroundColor;
    }
    public function setBorderColor($borderColor) {
        $this->borderColor = $borderColor;
    }
    public function setFontSize($fontSize) {
        $this->fontSize = $fontSize;
    }
    public function setFontFamily($fontFamily) {
        $this->fontFamily = $fontFamily;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    public function setElementType($elementType) {
        $this->elementType = $elementType;
    }
    public function setMargin($margin) {
        $this->margin = $margin;
    }
    public function setPadding($padding) {
        $this->padding = $padding;
    }
    public function setBorderWidth($borderWidth) {
        $this->borderWidth = $borderWidth;
    }
    public function setBorderStyle($borderStyle) {
        $this->borderStyle = $borderStyle;
    }
    public function setBorderRadius($borderRadius) {
        $this->borderRadius = $borderRadius;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'text_color' => $this->textColor,
            'background_color' => $this->backgroundColor,
            'border_color' => $this->borderColor,
            'font_size' => $this->fontSize,
            'font_family' => $this->fontFamily,
            'content' => $this->content,
            'element_type' => $this->elementType,
            'margin' => $this->margin,
            'padding' => $this->padding,
            'border_width' => $this->borderWidth,
            'border_style' => $this->borderStyle,
            'border_radius' => $this->borderRadius,
        ];
    }
}
