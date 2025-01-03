<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Dictionary;

use stdClass;

class DefaultDictionary extends AbstractDictionaryProvider
{
    public function __construct()
    {
        parent::__construct($this->loadStopWordsFromJson());
    }

    protected function loadStopWordsFromJson(): stdClass
    {
        $stopwordsFile = dirname(__DIR__, 2). '/data/stopwords.json';

        return json_decode(file_get_contents($stopwordsFile));
    }
}
