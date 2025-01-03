<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Test\Unit;

use PHPUnit\Framework\TestCase;
use Yeremi\Stopwords\Dictionary\AbstractDictionaryProvider;
use Yeremi\Stopwords\Service\StopwordsManager;

class AbstractDictionaryProviderTest extends TestCase
{
    public function testGetStopWordsReturnTrueWhenHasTheSameArrayStructure(): void
    {
        $provider = new class () extends AbstractDictionaryProvider {
            public function __construct()
            {

                $dictionary = <<<DICTIONARY
   {
     "language": "pt",
     "categories": [],
     "stopwords": {
       "adverbs": [
         "totalmente", "certamente"
       ],
       "articles": [
         "o", "a", "os", "as"
       ]
     }
   }
   DICTIONARY;

                $stopWords = json_decode($dictionary);

                parent::__construct($stopWords);
            }
        };

        $manager = new StopwordsManager();
        $manager->addDictionary($provider);

        $expected = [
            'adverbs' => [
                'totalmente',
                'certamente',
            ],
            'articles' => [
                'o',
                'a',
                'os',
                'as',
            ],
        ];

        $this->assertEquals($expected, $provider->stopwords());
    }

    public function testRemoveExistingStopWord(): void
    {
        $provider = new class () extends AbstractDictionaryProvider {
            public function __construct()
            {

                $dictionary = <<<DICTIONARY
   {
     "language": "pt",
     "categories": [],
     "stopwords": {
       "adverbs": [
         "completamente", "totalmente", "rapidamente"
       ]
     }
   }
   DICTIONARY;
                $stopWords = json_decode($dictionary);
                parent::__construct($stopWords);
            }
        };

        $manager = new StopwordsManager();
        $manager->addDictionary($provider);

        // Checking the existence of the word before removing
        $this->assertContains('totalmente', $manager->dictionary()['adverbs']);

        // Remove the word
        $manager->removeWordFromDictionary('totalmente');

        // Checking if the word doesn't exist in the category stopwords
        $this->assertNotContains('totalmente', $manager->dictionary()['adverbs']);

        $text = <<<TEXT
Todas as coisas do mundo não cabem totalmente numa idéia. 
Mas tudo cabe numa palavra, nesta palavra tudo. 
Arnaldo Antunes
TEXT;

        $cleanedText = $manager->extractRelevantWords($text);
        $expectedResult = ['todas', 'coisas', 'mundo', 'cabem', 'totalmente', 'idéia', 'cabe',  'palavra', 'arnaldo', 'antunes'];

        // Since "totalmente" has been removed from the dictionary, it is expected to be identified as a relevant word.
        $this->assertEquals($expectedResult, $cleanedText);
    }

    public function testRemoveNonExistingStopWord(): void
    {
        $provider = new class () extends AbstractDictionaryProvider {
            public function __construct()
            {

                $dictionary = <<<DICTIONARY
   {
     "language": "pt",
     "categories": [],
     "stopwords": {
       "adverbs": [
         "completamente", "totalmente", "rapidamente"
       ]
     }
   }
   DICTIONARY;
                $stopWords = json_decode($dictionary);

                parent::__construct($stopWords);
            }
        };

        $manager = new StopwordsManager();
        $manager->addDictionary($provider);
        $result = $provider->removeWord('inexistente');

        $this->assertFalse($result);

        $expected = [
            'adverbs' => [
                'completamente',
                'totalmente',
                'rapidamente',
            ],
        ];

        $this->assertEquals($expected, $provider->stopwords());
    }

    public function testImplementTwoProvidersReturnTrueWhenAssertValuesFromBothProviders(): void
    {
        $provider1 = new class () extends AbstractDictionaryProvider {
            public function __construct()
            {

                $dictionary = <<<DICTIONARY
   {
     "language": "pt",
     "categories": [],
     "stopwords": {
       "adverbs": [
         "completamente", "totalmente"
       ],
       "pronouns": ["eu", "tu"]
     }
   }
   DICTIONARY;
                $stopWords = json_decode($dictionary);

                parent::__construct($stopWords);
            }
        };

        $provider2 = new class () extends AbstractDictionaryProvider {
            public function __construct()
            {
                $dictionary = <<<DICTIONARY
   {
     "language": "pt",
     "categories": [],
     "stopwords": {
       "adverbs": [
         "rapidamente"
       ],
       "pronouns": ["ele", "ela"]
     }
   }
   DICTIONARY;
                $stopWords = json_decode($dictionary);
                parent::__construct($stopWords);
            }
        };

        $manager = new StopwordsManager();
        $manager->addDictionary($provider1);
        $manager->addDictionary($provider2);

        $allStopWords = $manager->dictionary();

        $expectedAdverbs = [
            'completamente',
            'totalmente',
            'rapidamente',
        ];
        $expectedPronouns = [
            'eu',
            'tu',
            'ele',
            'ela',
        ];

        foreach ($expectedAdverbs as $adverb) {
            $this->assertContains($adverb, $allStopWords['adverbs']);
        }

        foreach ($expectedPronouns as $pronoun) {
            $this->assertContains($pronoun, $allStopWords['pronouns']);
        }

        $this->assertArrayHasKey('adverbs', $allStopWords);
        $this->assertArrayHasKey('pronouns', $allStopWords);
        $this->assertNotEmpty($allStopWords['adverbs']);
        $this->assertNotEmpty($allStopWords['pronouns']);
    }
}
