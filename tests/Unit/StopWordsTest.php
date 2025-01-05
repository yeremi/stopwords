<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Test\Unit;

use PHPUnit\Framework\TestCase;
use Yeremi\Stopwords\StopWords;

class StopWordsTest extends TestCase
{
    public function testStopwordsStopShouldReturnOnlyValidWords()
    {
        $text = <<<TEXT
Todas as coisas do mundo não cabem numa idéia. 
Mas tudo cabe numa palavra, nesta palavra tudo. 
Arnaldo Antunes
TEXT;

        $cleanedText = StopWords::stop($text);
        $expectedResult = ['todas', 'coisas', 'mundo', 'cabem', 'idéia', 'cabe',  'palavra', 'arnaldo', 'antunes'];

        $this->assertEquals($expectedResult, $cleanedText);
    }

    public function testStopwordsStopShouldReturnEmptyArrayWhenReceivedAnEmptyString()
    {
        $text = '';
        $cleanedText = StopWords::stop($text);
        $this->assertEquals([], $cleanedText);
    }

    public function testStopwordsStopShouldReturnEmptyArrayAsReceivedStopwords()
    {
        $text = <<<TEXT
hoje, alguém neste mesmo ...caramba!
TEXT;
        $cleanedText = StopWords::stop($text);
        $this->assertEquals([], $cleanedText);
    }

    public function testWordsReturnAnArrayListWithAllWordsAsV1()
    {
        $source = dirname(__DIR__, 2) . '/data/stopwords.json';
        $dictionary = json_decode(file_get_contents($source), true);

        $allStopWords = [];
        foreach ($dictionary['stopwords'] as $category => $words) {
            if (is_array($words)) {
                $allStopWords = array_merge($allStopWords, $words);
            }
        }
        $rawWords = array_unique($allStopWords);

        $words = StopWords::words();
        $this->assertEquals($rawWords, $words);
    }
}
