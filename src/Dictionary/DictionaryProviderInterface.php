<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Dictionary;

use Yeremi\Stopwords\Core\StopwordsCategory;

interface DictionaryProviderInterface
{
    /**
     * Provide a list of the stopwords and its categories
     * @return array
     */
    public function stopwords(): array;

    /**
     * Provide a plain list of all words
     * @return array
     */
    public function listWords(): array;

    /**
     * Filter the words by category
     * @param StopwordsCategory $category
     * @return array
     */
    public function wordsByCategory(StopwordsCategory $category): array;

    /**
     * Remove a word form the dictionary independently of its category
     * @param string $word
     * @return bool
     */
    public function removeWord(string $word): bool;

    /**
     * Provide a full description of the dictionary provided
     * @return object
     */
    public function dictionary(): object;
}
