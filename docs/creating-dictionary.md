# Create and Add a Custom Dictionary

This library uses its own JSON Schema to manage functionality, which is based on
the [JSON Schema Draft 2020-12](https://json-schema.org/draft/2020-12/schema). You can add your own custom words by
utilizing any of the predefined stopword categories for your specific use case. Each category accepts an array of
strings.

Customizing this NLP library requires a basic understanding of linguistics to ensure a robust structure. We prioritize
maintaining a well-structured dictionary.

For a complete overview, see the [default dictionary](/data/stopwords.json).

## Example Dictionary Structure:

```json
{
  "language": "es",
  "stopwords": {
    "pronouns": [],
    "numerals": [],
    "temporal": [],
    "locative": [],
    "prepositions": [],
    "conjunctions": [],
    "articles": [],
    "adverbs": [],
    "interjections": [],
    "contractions": [],
    "others": []
  }
}
```

## Creating a Custom Dictionary

To add a custom dictionary, you need to follow the Stopword JSON schema as described above. Then, create a custom class
that extends the `AbstractDictionaryProvider` class.

### Example:

```php
class SpanishDictionary extends AbstractDictionaryProvider 
{
    public function __construct()
    {
        $stopWords = json_decode(file_get_contents('path/to/your/es-dictionary.json'));
        parent::__construct($stopWords);
    }
}
```

**Important:** When decoding your JSON file, avoid using associative arrays by default (ensure the second parameter in
`json_decode` is set to `true`).

## Testing your Dictionary

This library validate your custom dictionary in order to allow its usage, so you will be notified if it doesn't follow
our json schema. Nonetheless, you can test your dictionary beforehand
using PHPUnit. Here's an example of a simple test case:

```php
use PHPUnit\Framework\TestCase;
use Yeremi\Stopwords\Validation\StopwordsMetadataValidator;

class StopwordsManagerTest extends TestCase
{
    public function test_spanish_dictionary_is_valid()
    {
        $validator = new StopwordsMetadataValidator();
        $myDictionary = new SpanishDictionary());
        $isValid = $validator->validate($myDictionary);
        $this->assertTrue($isValid);
    }
}
```

## Implementing Your Dictionary

Once your custom dictionary is created, you can implement it using the `StopwordsManager` class. Here's an example of
how to integrate your custom dictionary:

```php
use Yeremi\Stopwords\Service\StopwordsManager;

$manager = new StopwordsManager();
$manager->addDictionary(new SpanishDictionary());

$sentence = "Sólo el conocimiento que llega desde dentro es el verdadero conocimiento. (Sócrates)";
$filteredWords = $manager->extractRelevantWords($sentence);
```

## Working with Multiple Dictionaries

You can add and work with multiple dictionaries by using the `StopwordsManager` class. Here's an example of how to
handle multiple dictionaries:

```php
use Yeremi\Stopwords\Service\StopwordsManager;

$manager = new StopwordsManager();
$manager->withoutDefaultDictionary(); // Remove default dictionary (Portuguese)
$manager->addDictionary(new CustomSpanishPeruDictionary());
$manager->addDictionary(new CustomSpanishArgentinaDictionary());
$manager->addDictionary(new CustomSpanishSpainDictionary());

$sentence = "Sólo el conocimiento que llega desde dentro es el verdadero conocimiento. (Sócrates)";
$filteredWords = $manager->extractRelevantWords($sentence);
```