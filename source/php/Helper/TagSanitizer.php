<?php

namespace ComponentLibrary\Helper;

class TagSanitizer implements TagSanitizerInterface
{
    /**
     * Allowed HTML tags that won't be stripped
     * @var array
     */
    private array $allowedTags = [
        'a', 'abbr', 'b', 'br', 'code', 'em', 'i', 'li', 'ol', 'p',
        'span', 'strong', 'sub', 'sup', 'u', 'ul'
    ];

    /**
     * Sanitize a string value by stripping dangerous HTML tags
     *
     * @param string $value The value to sanitize
     * @return string The sanitized value
     */
    public function sanitize(string $value): string
    {
        if (empty($value)) {
            return $value;
        }

        // Build allowed tags string for strip_tags
        $allowedTagsString = '<' . implode('><', $this->allowedTags) . '>';

        // Strip all tags except allowed ones
        $sanitized = strip_tags($value, $allowedTagsString);

        // Remove any script content that might have slipped through
        $sanitized = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $sanitized);

        // Remove event handlers from remaining tags
        $sanitized = preg_replace('/\s*on\w+\s*=\s*["\'][^"\']*["\']/i', '', $sanitized);

        // Remove javascript: protocols
        $sanitized = preg_replace('/javascript\s*:/i', '', $sanitized);

        return $sanitized;
    }

    /**
     * Sanitize an array of values recursively
     *
     * @param array $data The data array to sanitize
     * @param array $allowedKeys Keys that should not be sanitized
     * @return array The sanitized data array
     */
    public function sanitizeArray(array $data, array $allowedKeys = []): array
    {
        // Default keys to skip sanitization (slots, classes, objects)
        $defaultAllowedKeys = [
            'slot',
            'classList',
            'attributeList',
            'context',
            'lang',
            'buildAttributes'
        ];

        $allowedKeys = array_merge($defaultAllowedKeys, $allowedKeys);

        foreach ($data as $key => $value) {
            // Skip allowed keys
            if (in_array($key, $allowedKeys, true)) {
                continue;
            }

            if (is_string($value)) {
                $data[$key] = $this->sanitize($value);
            } elseif (is_array($value)) {
                $data[$key] = $this->sanitizeArray($value, $allowedKeys);
            }
            // Objects and other types are left as-is
        }

        return $data;
    }

    /**
     * Set custom allowed HTML tags
     *
     * @param array $tags Array of allowed tag names
     * @return self
     */
    public function setAllowedTags(array $tags): self
    {
        $this->allowedTags = $tags;
        return $this;
    }

    /**
     * Add tags to the allowed list
     *
     * @param array $tags Array of tag names to add
     * @return self
     */
    public function addAllowedTags(array $tags): self
    {
        $this->allowedTags = array_unique(array_merge($this->allowedTags, $tags));
        return $this;
    }
}
