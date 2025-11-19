<?php

namespace ComponentLibrary\Helper;

interface TagSanitizerInterface
{
    /**
     * Sanitize a string value by removing or escaping HTML tags
     *
     * @param string $value The value to sanitize
     * @return string The sanitized value
     */
    public function sanitize(string $value): string;

    /**
     * Sanitize an array of values recursively
     *
     * @param array $data The data array to sanitize
     * @param array $allowedKeys Keys that should not be sanitized (e.g., 'slot', 'classList')
     * @return array The sanitized data array
     */
    public function sanitizeArray(array $data, array $allowedKeys = []): array;
}
