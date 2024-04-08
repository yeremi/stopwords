<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Yeremi\StopWords\StopWords;

class StopWordsTest extends TestCase
{
    protected $stopwords;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stopwordsHandler = new Stopwords();
    }

    public function testStopwordsStopShouldReturnOnlyValidWords()
    {
        $text = "Todas as coisas do mundo não cabem numa idéia.";
        $text .= "Mas tudo cabe numa palavra, nesta palavra tudo.";
        $text .= "Arnaldo Antunes";

        $cleanedText = $this->stopwordsHandler::stop($text);
        $expectedResult = ["coisas", "mundo", "cabem", "idéia", "cabe","palavra", "arnaldo", "antunes"];
        $this->assertEquals($expectedResult, $cleanedText);
    }

    public function testStopwordsStopShouldReturnEmptyArrayWhenReceivedAnEmptyString()
    {
        $text = "";
        $cleanedText = $this->stopwordsHandler::stop($text);
        $this->assertEquals([], $cleanedText);
    }

    public function testStopwordsStopShouldReturnEmptyArrayAsReceivedStopwords()
    {
        $text = "alguem esteve recentemente";
        $cleanedText = $this->stopwordsHandler::stop($text);
        $this->assertEquals([], $cleanedText);
    }
}
