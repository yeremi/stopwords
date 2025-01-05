<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Test\Unit;

use PHPUnit\Framework\TestCase;
use Yeremi\Stopwords\Core\Normalizer;

class NormalizerTest extends TestCase
{
    public function testNormalizeRemovesUnwantedCharacters()
    {
        $normalizer = new Normalizer();
        $input = 'Hello, World! This is a test: 123.';
        $expected = ['hello', 'world', 'this', 'is', 'a', 'test'];
        $this->assertSame($expected, $normalizer->normalize($input));
    }

    public function testNormalizeHandlesAccentsAndHyphens()
    {
        $normalizer = new Normalizer();
        $input = 'Olá, mundo!.';
        $expected = ['olá', 'mundo'];
        $this->assertSame($expected, $normalizer->normalize($input));
    }
}
