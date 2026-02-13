<?php

namespace App\Http;

use DOMDocument;
use DOMElement;
use DOMNode;

class EditorHtmlSanitizer
{
    private const array ALLOWED_TAGS = [
        'p',
        'br',
        'strong',
        'em',
        'b',
        'i',
        'u',
        'ul',
        'ol',
        'li',
        'h2',
        'h3',
        'blockquote',
        'a',
        'img',
        'figure',
        'figcaption',
    ];

    private const array ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'class'],
    ];

    public function sanitize(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previousState = libxml_use_internal_errors(true);

        $document->loadHTML(
            mb_convert_encoding('<div>'.$html.'</div>', 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousState);

        if (! $document->documentElement instanceof DOMElement) {
            return '';
        }

        $this->sanitizeNode($document->documentElement);

        return $this->innerHtml($document->documentElement);
    }

    private function sanitizeNode(DOMNode $node): void
    {
        $children = [];

        foreach ($node->childNodes as $childNode) {
            $children[] = $childNode;
        }

        foreach ($children as $childNode) {
            if (! $childNode instanceof DOMElement) {
                continue;
            }

            $this->sanitizeElement($childNode);
        }
    }

    private function sanitizeElement(DOMElement $element): void
    {
        $tagName = strtolower($element->tagName);

        if (! in_array($tagName, self::ALLOWED_TAGS, true)) {
            $this->unwrap($element);

            return;
        }

        $allowedAttributes = self::ALLOWED_ATTRIBUTES[$tagName] ?? [];

        for ($index = $element->attributes->length - 1; $index >= 0; $index--) {
            $attribute = $element->attributes->item($index);

            if ($attribute === null) {
                continue;
            }

            $attributeName = strtolower($attribute->name);
            $attributeValue = trim($attribute->value);

            if (str_starts_with($attributeName, 'on') || $attributeName === 'style') {
                $element->removeAttribute($attributeName);

                continue;
            }

            if (! in_array($attributeName, $allowedAttributes, true)) {
                $element->removeAttribute($attributeName);

                continue;
            }

            if (
                $attributeName === 'href'
                && ! $this->isSafeUrl($attributeValue, false)
            ) {
                $element->removeAttribute($attributeName);

                continue;
            }

            if (
                $attributeName === 'src'
                && ! $this->isSafeUrl($attributeValue, true)
            ) {
                $element->removeAttribute($attributeName);
            }
        }

        if (strtolower($element->tagName) === 'a' && $element->getAttribute('target') === '_blank') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }

        $this->sanitizeNode($element);
    }

    private function unwrap(DOMElement $element): void
    {
        $parentNode = $element->parentNode;

        if ($parentNode === null) {
            return;
        }

        while ($element->firstChild !== null) {
            $parentNode->insertBefore($element->firstChild, $element);
        }

        $parentNode->removeChild($element);
    }

    private function isSafeUrl(string $value, bool $isImageSource): bool
    {
        $normalizedValue = trim(html_entity_decode($value, ENT_QUOTES | ENT_HTML5));

        if ($normalizedValue === '') {
            return false;
        }

        if (str_starts_with($normalizedValue, '#')) {
            return ! $isImageSource;
        }

        if (str_starts_with($normalizedValue, '/')) {
            return true;
        }

        if (preg_match('/^(javascript|data|vbscript):/i', $normalizedValue) === 1) {
            return false;
        }

        $scheme = parse_url($normalizedValue, PHP_URL_SCHEME);

        if (! is_string($scheme) || $scheme === '') {
            return true;
        }

        $allowedSchemes = ['http', 'https', 'mailto', 'tel'];

        if (! in_array(strtolower($scheme), $allowedSchemes, true)) {
            return false;
        }

        if ($isImageSource && in_array(strtolower($scheme), ['mailto', 'tel'], true)) {
            return false;
        }

        return true;
    }

    private function innerHtml(DOMElement $element): string
    {
        $html = '';

        foreach ($element->childNodes as $childNode) {
            $html .= $element->ownerDocument?->saveHTML($childNode) ?? '';
        }

        return $html;
    }
}
