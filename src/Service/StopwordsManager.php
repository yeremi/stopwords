<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Service;

use InvalidArgumentException;
use SplObjectStorage;
use UnexpectedValueException;
use Yeremi\Stopwords\Core\Normalizer;
use Yeremi\Stopwords\Core\StopwordsCategory;
use Yeremi\Stopwords\Dictionary\DefaultDictionary;
use Yeremi\Stopwords\Dictionary\DictionaryProviderInterface;
use Yeremi\Stopwords\Validation\StopwordsMetadataValidator;

class StopwordsManager
{
    private bool $useDefaultProvider = true;

    private readonly SplObjectStorage $providers;

    private readonly StopwordsMetadataValidator $validator;

    private readonly Normalizer $normalizer;

    public function __construct(
        array $providers = []
    ) {
        $this->providers = new SplObjectStorage();
        $this->validator = new StopwordsMetadataValidator();
        $this->normalizer = new Normalizer();

        if ($this->useDefaultProvider) {
            $defaultProvider = new DefaultDictionary();
            if (! $this->validator->validate($defaultProvider->dictionary())) {
                throw new InvalidArgumentException('Invalid stopwords metadata provided.');
            } else {
                $this->providers->attach($defaultProvider);
            }
        }

        foreach ($providers as $provider) {
            if (! $provider instanceof DictionaryProviderInterface) {
                throw new InvalidArgumentException(
                    'All providers must implement StopWordsProviderInterface.'
                );
            }
            $this->addDictionary($provider);
        }
    }

    /**
     * Disables the default stop words provider by removing it from the list of providers.
     *
     * @return $this
     */
    public function withoutDefaultDictionary(): self
    {
        $this->useDefaultProvider = false;

        foreach ($this->providers as $provider) {
            if ($provider instanceof DefaultDictionary) {
                $this->providers->detach($provider);

                break;
            }
        }

        return $this;
    }

    /**
     * Allow adding new dictionary with custom words
     *
     * @param DictionaryProviderInterface $provider
     * @return void
     */
    public function addDictionary(DictionaryProviderInterface $provider): void
    {
        if (! $this->validator->validate($provider->dictionary())) {
            throw new InvalidArgumentException('Invalid stopwords metadata provided.');
        }

        if (! $this->providers->contains($provider)) {
            $this->providers->attach($provider);
        }
    }

    /**
     * List words organized by categories provided by the dictionaries
     * @return array
     */
    public function dictionary(): array
    {
        $allStopWords = [];

        foreach ($this->providers as $provider) {
            /** @var DictionaryProviderInterface $provider */
            $stopWords = $provider->stopwords();

            foreach ($stopWords as $category => $words) {
                if (! is_array($words)) {
                    throw new UnexpectedValueException(
                        sprintf('Expected array of words for category "%s", got "%s".', $category, gettype($words))
                    );
                }

                if (! isset($allStopWords[$category])) {
                    $allStopWords[$category] = [];
                }

                $allStopWords[$category] = array_merge($allStopWords[$category], $words);
            }
        }

        foreach ($allStopWords as $category => $words) {
            $allStopWords[$category] = array_unique($words);
        }

        return $allStopWords;
    }

    /**
     * List words by category
     *
     * @param StopwordsCategory $category
     * @return array
     */
    public function dictionaryByCategory(StopwordsCategory $category): array
    {
        $stopWords = [];

        foreach ($this->providers as $provider) {
            /** @var DictionaryProviderInterface $provider */
            $words = $provider->wordsByCategory($category);
            if (! empty($words)) {
                $stopWords = array_merge($stopWords, $words);
            }
        }

        return array_unique($stopWords);
    }

    /**
     * Removes a word from all categories in the dictionary.
     *
     * @param string $word
     * @return void
     */
    public function removeWordFromDictionary(string $word): void
    {
        $wordRemoved = false;
        foreach ($this->providers as $provider) {
            /** @var DictionaryProviderInterface $provider */
            if ($provider->removeWord($word)) {
                $wordRemoved = true;
            }
        }

        if (! $wordRemoved) {
            throw new InvalidArgumentException(sprintf('Word "%s" not found in any dictionary.', $word));
        }
    }

    public function extractRelevantWords(string $sentence): array
    {
        $normalizedWords = $this->normalizer->normalize($sentence);
        $stopwords = array_reduce($this->dictionary(), 'array_merge', []);

        // Re-index the array to remove gaps in the indices (from the array_diff operation)
        return array_values(array_diff($normalizedWords, $stopwords));
    }
}
