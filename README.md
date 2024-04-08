# StopWords for Portuguese Brazilian Language / PT-BR

##### PHP client StopWords for Portuguese Brazilian Language

Stopwords (NPL) for Portuguese Brazilian Language PHP client provides a convenient toolset for developers working with
Natural Language Processing (NLP) tasks in Brazilian Portuguese. This Composer package offers seamless integration,
allowing easy access to a comprehensive list of stopwords commonly used in text analysis and preprocessing. Enhance your
NLP projects by effortlessly filtering out irrelevant words, optimizing text processing, and improving overall accuracy.
Harness the power of stopwords tailored specifically for the nuances of Brazilian Portuguese with this essential PHP
client.

You can also use stop words in SEO to avoid search engines, saving space and time in processing large data during
crawling or indexing.

## Setup

To run this project, install it locally using Composer:

```shell
composer require yeremi/stopwords
```

## How to use

```php
use Yeremi\StopWords\StopWords;

class StopWordsHandler {

    public function __construct(
        private Stopwords $stopwords
    ) {}
    
    public function handler(string $string): array 
    {
        return $this->stopwords::stop($string);
    }
}

$stopwords = new Stopwords();
$handlesClass = new StopWordsHandler($stopwords);

$string = 'put your long text here';
var_export($handlesClass->handler($string));
```

## License

Copyright (c) 2017 Yeremi Loli
This software is licensed under the GNU General Public License v3.0. [View the license](LICENSE).
