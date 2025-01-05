<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Validation;

use InvalidArgumentException;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;

class StopwordsMetadataValidator
{
    public function validate(object $metadata): bool
    {
        $schemaPath = dirname(__DIR__, 2) . '/schema/stopwords-schema.json';
        $schema = json_decode(file_get_contents($schemaPath));

        $validator = new Validator();
        $result = $validator->validate($metadata, $schema);

        if ($result->isValid()) {
            return true;
        }

        $error = (new ErrorFormatter())->formatFlat($result->error());
        if (isset($error[0])) {
            throw new InvalidArgumentException($error[0]);
        }

        return false;
    }
}
