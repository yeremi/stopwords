<?php

declare(strict_types=1);

namespace Yeremi\Stopwords\Core;

enum StopwordsCategory: string
{
    case PRONOUNS = 'pronouns';
    case PREPOSITIONS = 'prepositions';
    case CONJUNCTIONS = 'conjunctions';
    case ARTICLES = 'articles';
    case ADVERBS = 'adverbs';
    case NUMERALS = 'numerals';
    case TEMPORAL = 'temporal';
    case LOCATIVE = 'locative';
    case INTERJECTION = 'interjections';
    case CONTRACTIONS = 'contractions';
    case OTHERS = 'others';
}
