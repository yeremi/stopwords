<?php

namespace Yeremi\Stopwords\Test\Unit;

use PHPUnit\Framework\TestCase;
use Yeremi\Stopwords\Core\StopwordsCategory;
use Yeremi\Stopwords\Dictionary\DefaultDictionary;
use Yeremi\Stopwords\Service\StopwordsManager;

class StopwordsManagerTest extends TestCase
{
    public function testGetStopWordsByCategoryReturnTrueWhenValidateTwoAdverbs()
    {
        $manager = new StopwordsManager();
        $manager->addDictionary(new DefaultDictionary());

        $this->assertContains('sempre', $manager->dictionaryByCategory(StopwordsCategory::ADVERBS));
        $this->assertContains('ainda', $manager->dictionaryByCategory(StopwordsCategory::ADVERBS));
    }

    public function testWithoutDefaultProviderReturnTrueWhenUsedItWithTheManager()
    {
        $manager = new StopwordsManager();
        $manager->withoutDefaultDictionary();
        $stopWords = $manager->dictionary();
        $this->assertEmpty($stopWords);
    }

    public function testWithDefaultProviderReturnTrue(): void
    {
        $source = dirname(__DIR__, 2) . '/data/stopwords.json';
        $dictionary = json_decode(file_get_contents($source));

        $manager = new StopwordsManager();
        $stopWords = $manager->dictionary();
        $this->assertNotEmpty($stopWords);
        $stopWordsWithDefault = $manager->dictionary();

        $this->assertArrayHasKey('pronouns', $stopWordsWithDefault);
        $this->assertArrayHasKey('prepositions', $stopWordsWithDefault);
        $this->assertArrayHasKey('conjunctions', $stopWordsWithDefault);
        $this->assertArrayHasKey('articles', $stopWordsWithDefault);
        $this->assertArrayHasKey('adverbs', $stopWordsWithDefault);

        $this->assertEquals(array_unique($dictionary->stopwords->pronouns), $stopWordsWithDefault['pronouns'], 'Default Pronouns');
        $this->assertEquals(array_unique($dictionary->stopwords->prepositions), $stopWordsWithDefault['prepositions'], 'Default Prepositions');
        $this->assertEquals(array_unique($dictionary->stopwords->conjunctions), $stopWordsWithDefault['conjunctions'], 'Default Conjunctions');
        $this->assertEquals(array_unique($dictionary->stopwords->articles), $stopWordsWithDefault['articles'], 'Default Articles');
        $this->assertEquals(array_unique($dictionary->stopwords->adverbs), $stopWordsWithDefault['adverbs'], 'Default Adverbs');
        $this->assertContains('depressa', $stopWordsWithDefault['adverbs']);
    }
}
