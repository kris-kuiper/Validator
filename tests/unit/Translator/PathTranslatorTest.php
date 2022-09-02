<?php

declare(strict_types=1);

namespace tests\unit\Translator;

use KrisKuiper\Validator\Translator\PathTranslator;
use PHPUnit\Framework\TestCase;

final class PathTranslatorTest extends TestCase
{
    public function testIfCorrectValueIsReturnedWhenUsingDeepArrays(): void
    {
        $data = [
            'people' => [
                ['name' => 'Smith', 'age' => 52],
                ['name' => 'Morris', 'age' => 67]
            ],
            'animals' => [
                ['name' => 'Boefje', 'age' => 3],
                ['name' => 'Crock', 'age' => 27,]
            ],
        ];

        $translator = new PathTranslator($data);

        $this->assertEquals([52, 67, 3, 27], $translator->get('*.*.age'));
        $this->assertEquals(['Smith', 52, 'Morris', 67, 'Boefje', 3, 'Crock', 27], $translator->get('*.*.*'));
        $this->assertEquals([$data['people'][0], $data['people'][1], $data['animals'][0], $data['animals'][1]], $translator->get('*.*'));
        $this->assertEquals($data['people'][0], $translator->get('people.0')[0]);
        $this->assertEquals($data['people'][0]['name'], $translator->get('people.0.name')[0]);
        $this->assertEquals($data['people'][1]['name'], $translator->get('people.1.name')[0]);
        $this->assertEquals($data['people'][1], $translator->get('people.1')[0]);
    }

    public function testIfCorrectValueIsReturnedWhenUsingIntegerIndexes(): void
    {
        $data = [1, 2, 3];
        $translator = new PathTranslator($data);

        $this->assertSame($translator->path(0)->current()->getValue(), $data[0]);
        $this->assertSame($translator->path(1)->current()->getValue(), $data[1]);
        $this->assertSame($translator->path(2)->current()->getValue(), $data[2]);

        $this->assertSame($translator->path(0)->current()->getPath(), [0]);
        $this->assertSame($translator->path(1)->current()->getPath(), [1]);
        $this->assertSame($translator->path(2)->current()->getPath(), [2]);

        $this->assertSame($translator->path(0)->getValues(), [$data[0]]);
        $this->assertSame($translator->path(1)->getValues(), [$data[1]]);
        $this->assertSame($translator->path(2)->getValues(), [$data[2]]);
    }

    public function testIfCorrectValueIsReturnedWhenUsingStringIndexes(): void
    {
        $data = [
            'people' => '1',
            'animals' => '2',
        ];

        $translator = new PathTranslator($data);

        $this->assertSame($translator->path('people')->current()->getValue(), $data['people']);
        $this->assertSame($translator->path('animals')->current()->getValue(), $data['animals']);

        $this->assertSame($translator->path('people')->current()->getPath(), ['people']);
        $this->assertSame($translator->path('animals')->current()->getPath(), ['animals']);

        $this->assertSame($translator->path('people')->getValues(), [$data['people']]);
        $this->assertSame($translator->path('animals')->getValues(), [$data['animals']]);
    }

    public function testIfCorrectValueIsReturnedWhenUsingDeeperIndexes(): void
    {
        $data = [
            'people' => [
                'name' => 'Brenda',
                'age' => 67
            ],
            'animal' => [
                'name' => 'Boefje',
                'age' => 3
            ],
        ];

        $translator = new PathTranslator($data);

        $this->assertSame($translator->path('people.name')->current()->getValue(), $data['people']['name']);
        $this->assertSame($translator->path('people.age')->current()->getValue(), $data['people']['age']);
        $this->assertSame($translator->path('people')->current()->getValue(), $data['people']);

        $this->assertSame($translator->path('animal.name')->current()->getValue(), $data['animal']['name']);
        $this->assertSame($translator->path('animal.age')->current()->getValue(), $data['animal']['age']);
        $this->assertSame($translator->path('animal')->current()->getValue(), $data['animal']);

        $this->assertSame($translator->path('animal.name')->getValues(), [$data['animal']['name']]);
        $this->assertSame($translator->path('animal.age')->getValues(), [$data['animal']['age']]);
        $this->assertSame($translator->path('animal')->getValues(), [$data['animal']]);
    }

    public function testIfCorrectValueIsReturnedWhenUsingWildcards(): void
    {
        $data = [
            'people' => [
                'name' => 'Brenda',
                'age' => 67
            ],
            'animal' => [
                'name' => 'Boefje',
                'age' => 3
            ],
        ];

        $translator = new PathTranslator($data);

        $this->assertSame($translator->path('*.name')->current()->getValue(), $data['people']['name']);
        $this->assertSame($translator->path('*.age')->current()->getValue(), $data['people']['age']);

        $this->assertSame($translator->path('*.name')->getValues(), [$data['people']['name'], $data['animal']['name']]);
        $this->assertSame($translator->path('*.age')->getValues(), [$data['people']['age'], $data['animal']['age']]);
    }

    public function testIfCorrectValueIsReturnedWhenUsingMultipleWildcards(): void
    {
        $data = [
            'people' => [
                ['name' => 'Smith', 'age' => 52],
                ['name' => 'Morris', 'age' => 67]
            ],
            'animals' => [
                ['name' => 'Boefje', 'age' => 3],
                ['name' => 'Crock', 'age' => 27,]
            ],
        ];

        $translator = new PathTranslator($data);

        $this->assertSame($translator->path('*.*.age')->current()->getValue(), 52);
        $this->assertSame($translator->path('*.*.age')->current()->getPath(), ['people', 0, 'age']);
    }


    public function testIfCorrectArrayIsReturnedUsingConstructorToSetValues(): void
    {
        $data = ['foo' => 'bar'];

        $translator = new PathTranslator($data);
        $this->assertSame($data, $translator->getData());
    }

    public function testIfCorrectArrayIsReturnedWhenAddingNewKey(): void
    {
        $data = ['foo' => 'bar'];

        $translator = new PathTranslator($data);
        $translator->add('quez', 'bazz');

        $this->assertSame(['foo' => 'bar', 'quez' => 'bazz'], $translator->getData());
    }

    public function testIfCorrectArrayIsReturnedWhenOverwritingKey(): void
    {
        $data = ['foo' => 'bar'];

        $translator = new PathTranslator($data);
        $translator->set('foo', 'bazz');

        $this->assertSame(['foo' => 'bazz'], $translator->getData());
    }

    public function testIfCorrectResultIsReturnedWhenCheckingIfStringKeyExists(): void
    {
        $data = [
            'foo' => 'bar',
            'quez' => [
                '1' => ['foo' => true],
                '2' => ['foo' => true]
            ]
        ];

        $translator = new PathTranslator($data);
        $translator->set('foo', 'bazz');

        $this->assertTrue($translator->has('foo'));
        $this->assertTrue($translator->has('quez.*.foo'));
    }

    public function testIfCorrectArrayIsReturnedWhenRemovingKey(): void
    {
        $data = [
            'foo' => 'bar',
            'quez' =>'bazz'
        ];

        $translator = new PathTranslator($data);
        $translator->remove('foo');

        $this->assertSame(['quez' => 'bazz'], $translator->getData());
    }

    public function testIfCorrectDataIsReturnedWhenOverwritingData(): void
    {
        $data1 = ['foo' => 'bar'];
        $data2 = ['quez' =>'bazz'];

        $translator = new PathTranslator($data1);
        $translator->setData($data2);

        $this->assertSame($data2, $translator->getData());
    }

    public function testIfCorrectArrayIsReturnedWhenAddingDataBasedOnString(): void
    {
        $data1 = [];
        $data2 =['foo' => 'bar'];

        $translator = new PathTranslator($data1);
        $translator->set($data2);

        $this->assertSame($data2, $translator->getData());
    }
}
