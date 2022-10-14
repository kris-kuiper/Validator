<?php

declare(strict_types=1);

namespace tests\unit\Collections;

use KrisKuiper\Validator\Blueprint\Combine\Combine;
use KrisKuiper\Validator\Blueprint\Custom\Custom;
use KrisKuiper\Validator\Blueprint\DefaultValue;
use KrisKuiper\Validator\Blueprint\Messages\ContainsLetter;
use KrisKuiper\Validator\Collections\CustomCollection;
use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Collections\FieldCollection;
use KrisKuiper\Validator\Collections\FieldMessageCollection;
use KrisKuiper\Validator\Collections\RuleMessageCollection;
use KrisKuiper\Validator\Combine\CombineProxy;
use KrisKuiper\Validator\Parser\Message;
use PHPUnit\Framework\TestCase;

final class CollectionsTest extends TestCase
{
    public function testIfCustomCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new Custom('custom', static function () {
        });

        $collection = new CustomCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfRuleMessageCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new Message(new ContainsLetter('message'));
        $collection = new RuleMessageCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfCombineProxyCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new CombineProxy(new Combine(), new FieldCollection(), new DefaultValue('', null));
        $collection = new CombineProxyCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfFieldMessageCollectionReturnsCorrectItemWhenUsingCurrentMethod(): void
    {
        $item = new Message(new ContainsLetter('message'));
        $collection = new FieldMessageCollection($item);
        $this->assertSame($item, $collection->current());
    }

    public function testIfCollectionReturnsCorrectDataWhenUsingToArrayMethod(): void
    {
        $item = new Message(new ContainsLetter('message'));
        $collection = new RuleMessageCollection($item);
        $this->assertSame([$item], $collection->toArray());
    }
}
