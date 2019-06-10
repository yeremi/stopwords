# StopWords for Portuguese Brazilian Language / PT-BR
PHP client StopWords for Portuguese Brazilian Language
One of our major performance optimizations for query is filtered and removing the most unless common Portuguese dictionary words before submitting queries to the database full text engine.  It's shocking to see how little of most posts remain when you remove empty words from the Portuguese dictionary.
This StopWord contain 603 "stop words" collection that helps narrow and narrow query results by running the query dramatically faster.
You can also use stop words in SEO to avoid search engines, saving space and time in processing large data during crawling or indexing.

## Setup
To run this project, install it locally using Composer by adding the following in your `composer.json` file:

```json
{
  "require": {
    "yeremi/stopwords": "*"
  }
}
```

then run the installation by executing: `composer install`

### Autoloading
Use autoloading to make the client available in your PHP project:

```php
require_once("vendor/autoload.php");
```

## Usage example

```php
$string = 'put your long text here';
$output_array = Yeremi\StopWords::stop($string);

print_r($output_array);
```

## License
Copyright (c) 2017 Yeremi Loli
This software is licensed under the GNU General Public License v3.0. [View the license](LICENSE).
