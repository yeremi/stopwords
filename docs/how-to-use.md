
## How to Use

---

### Basic Example

```php
use Yeremi\Stopwords\StopwordsManager;

// Text to analyze
$text = "O documento foi completamente revisado e está totalmente correto.";

$manager = new StopwordsManager();
$filteredWords = $manager->extractRelevantWords($text);

print_r($filteredWords);
```

### Listing words from dictionary

```php
use Yeremi\Stopwords\Service\StopwordsManager;

$manager = new StopwordsManager();

// List words organized by the categories provided in the dictionaries
$dictionary = $manager->dictionary();

// List words by category
$adverbs = $manager->dictionaryByCategory(StopwordsCategory::ADVERBS);
```

### Remove words from the dictionary

```php
use Yeremi\Stopwords\Service\StopwordsManager;

$manager = new StopwordsManager();
$manager->removeWordFromDictionary('igualmente');
```

### Disable the default dictionary

```php
use Yeremi\Stopwords\Service\StopwordsManager;

$manager = new StopwordsManager();
$manager->withoutDefaultDictionary();

```