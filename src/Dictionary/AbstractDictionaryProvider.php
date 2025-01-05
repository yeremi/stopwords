<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Dictionary;

use stdClass;
use Yeremi\Stopwords\Core\StopwordsCategory;

abstract class AbstractDictionaryProvider implements DictionaryProviderInterface
{
    public function __construct(
        protected stdClass $dictionary
    ) {
    }

    public function stopwords(): array
    {
        return (array)$this->dictionary()->stopwords;
    }

    public function dictionary(): object
    {
        return $this->dictionary;
    }

    public function listWords(): array
    {
        $allStopWords = [];
        foreach ($this->stopwords() as $category => $words) {
            if (is_array($words)) {
                $allStopWords = array_merge($allStopWords, $words);
            }
        }

        return array_unique($allStopWords);
    }

    public function removeWord(string $word): bool
    {
        foreach ($this->stopwords() as $category => &$words) {
            if (is_array($words) && ($key = array_search($word, $words, true)) !== false) {
                unset($words[$key]);
                $this->dictionary->stopwords->$category = array_values($words); // Reindex the sub-array

                return true;
            }
        }

        return false;
    }

    public function wordsByCategory(StopwordsCategory $category): array
    {
        return $this->stopwords()[$category->value] ?? [];
    }
}
