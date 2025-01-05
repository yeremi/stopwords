## Migration instructions

#### Before (v1):
```php
use Yeremi\Stopwords;

$result = StopWords::stop("Esta é uma frase de exemplo.");
```

#### After (v2):
```php
use Yeremi\Stopwords\Services\StopwordsManager;

$manager = new StopwordsManager();
$result = $manager->extractRelevantWords("Esta é uma frase de exemplo.");
```
