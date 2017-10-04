# StopWords for PT-BR

PHP client for StopWords on Portuguese Brazilian Language

## Installation

Install the API client with Composer. Add this to your `composer.json`:

```json
{
  "require": {
    "yeremi/stopwords": "*"
  }
}
```

Then install with:

```
composer install
```

Use autoloading to make the client available in PHP:

```php
require_once("vendor/autoload.php");
```

## Usage

```php
$string = 'put your long text here';
$output_array = Yeremi\StopWords::stop($string);

print_r($output_array);
```

## License

This software is licensed under the MIT License. [View the license](LICENSE).
