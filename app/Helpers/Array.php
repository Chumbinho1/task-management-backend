<?php

function convertKeysToSnakeCase(array $array): array
{
    $result = [];
    foreach ($array as $key => $value) {
        $newKey = strtolower(preg_replace('/[A-Z]/', '_$0', $key));
        $newKey = ltrim($newKey, '_'); // Remove leading underscore if any
        if (is_array($value)) {
            $value = convertKeysToSnakeCase($value); // Recursively apply the function to nested arrays
        }
        $result[$newKey] = $value;
    }

    return $result;
}
