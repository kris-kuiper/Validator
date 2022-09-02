<?php

declare(strict_types=1);

namespace tests\unit\Blueprint\Collections;

use KrisKuiper\Validator\Blueprint\Collections\CustomCollection;
use KrisKuiper\Validator\Blueprint\Collections\FieldNameCollection;
use KrisKuiper\Validator\Blueprint\Collections\FieldOptionCollection;
use KrisKuiper\Validator\Blueprint\Collections\MiddlewareCollection;
use KrisKuiper\Validator\Blueprint\Collections\MiddlewareListCollection;
use KrisKuiper\Validator\Blueprint\Collections\RuleCollection;
use KrisKuiper\Validator\Blueprint\Custom\Custom;
use KrisKuiper\Validator\Blueprint\FieldOptions;
use KrisKuiper\Validator\Blueprint\Middleware\Middleware;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\Trim;
use KrisKuiper\Validator\Blueprint\MiddlewareList;
use KrisKuiper\Validator\Blueprint\Rules\IsString;
use KrisKuiper\Validator\Blueprint\ValueObjects\FieldName;
use PHPUnit\Framework\TestCase;

final class CollectionsTest extends TestCase
{
    public function testIfCustomCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new Custom('custom', static function() {
        });

        $collection = new CustomCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfFieldNameCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new FieldName('field');
        $collection = new FieldNameCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfFieldOptionsCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new FieldOptions();
        $collection = new FieldOptionCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfMiddlewareCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new Middleware(new Trim());
        $collection = new MiddlewareCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfMiddlewareListCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new MiddlewareList();
        $collection = new MiddlewareListCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfRuleCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new IsString();
        $collection = new RuleCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfCollectionReturnsCorrectCountWhenAppendingNewRule(): void
    {
        $item = new IsString();
        $collection = new RuleCollection($item);
        $this->assertSame(1, $collection->count());
    }

    public function testIfCollectionReturnsCorrectDataWhenUsingToArrayMethod(): void
    {
        $item = new IsString();
        $collection = new RuleCollection($item);
        $this->assertSame([$item], $collection->toArray());
    }
}
