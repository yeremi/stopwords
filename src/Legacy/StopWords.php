<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Legacy;

use Yeremi\Stopwords\Dictionary\DefaultDictionary;
use Yeremi\Stopwords\Service\StopwordsManager;

class StopWords
{
    /**
     * @param string $string
     *
     * @return array
     */
    public static function stop(string $string): array
    {
        trigger_error(
            'The StopWords class is deprecated and will be removed in a future version. Please use StopwordsManager instead.',
            E_USER_DEPRECATED
        );

        if (empty($string)) {
            return [];
        }

        $manager = new StopwordsManager();

        return $manager->extractRelevantWords($string);
    }

    /**
     * @return array
     */
    public static function words(): array
    {
        trigger_error(
            'The StopWords class is deprecated and will be removed in a future version. Please use StopwordsManager instead.',
            E_USER_DEPRECATED
        );

        $defaultDictionary = new DefaultDictionary();

        return $defaultDictionary->listWords();
    }
}
