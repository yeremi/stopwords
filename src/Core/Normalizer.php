<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Core;

class Normalizer
{
    public function normalize(string $string): array
    {
        if (empty(trim($string))) {
            return [];
        }

        // Convert the input string to lowercase to make it case-insensitive
        $normalized = mb_strtolower($string);

        // Add a space after any punctuation mark that is not followed by a space
        // This ensures proper spacing between punctuation and words
        $normalized = preg_replace('/([[:punct:]])([^ ])/u', '$1 $2', $normalized);

        // Remove new lines and replace with an empty space
        $normalized = preg_replace('/\s+/', ' ', (string) $normalized);

        // Remove any non-alphabetic characters except letters, spaces, accents, and hyphens
        // This filters out unwanted symbols, numbers, and non-letter characters
        $normalized = preg_replace('/[^a-záàãâéèêíìóòôõúùç\s-]/u', '', (string) $normalized);

        $normalized = trim((string) $normalized);

        if (str_contains($normalized, ' ')) {
            // Split the string into an array of words by separating by spaces
            // The array is filtered to remove duplicates and any empty values
            return array_filter(array_unique(explode(' ', $normalized)));
        }

        return [$normalized];
    }
}
