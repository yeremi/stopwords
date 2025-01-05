<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Test\Unit;

use Opis\JsonSchema\Validator;
use PHPUnit\Framework\TestCase;
use Yeremi\Stopwords\Validation\StopwordsMetadataValidator;

class StopwordsMetadataValidatorTest extends TestCase
{
    public function testStopwordsMetadataValidatorReturnFalseOnInvalidJSONFormat()
    {
        $file = dirname(__DIR__, 2) . '/schema/stopwords-schema.json';
        $schema = json_decode(file_get_contents($file));

        $data = <<<DICTIONARY
{
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

        $data = json_decode($data);

        $validator = new Validator();
        $validator->setMaxErrors(3);
        $result = $validator->validate($data, $schema);

        $this->assertFileExists($file);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->hasError());
    }

    public function testStopwordsMetadataValidatorReturnTrueOnDefaultDictionary()
    {
        $file = dirname(__DIR__, 2) . '/schema/stopwords-schema.json';
        $schema = json_decode(file_get_contents($file));

        $source = dirname(__DIR__, 2) . '/data/stopwords.json';
        $data = json_decode(file_get_contents($source));

        $validator = new Validator();
        $validator->setMaxErrors(3);

        $result = $validator->validate($data, $schema);
        $this->assertFileExists($file);
        $this->assertFileExists($source);
        $this->assertTrue($result->isValid());
    }

    public function testStopwordsMetadataValidatorReturnTrueWhenCustomDictionaryFollowTheJsonSchema()
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
        $metadataValidator = new StopwordsMetadataValidator();
        $isValid = $metadataValidator->validate($stopWords);
        $this->assertTrue($isValid);
    }
}
