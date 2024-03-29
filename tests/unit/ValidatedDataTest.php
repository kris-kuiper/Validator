<?php

declare(strict_types=1);

namespace tests\unit;

use JsonException;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\ValidatedData;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatedDataTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenSimpleDataIsValidated(): void
    {
        $data = [
            'name' => 'Brenda',
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->field('name')->alpha();
        $validator->field('age')->between(0, 100);
        $validator->execute();

        $this->assertEquals($data, $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenOnlyOneDataFieldIsValidated(): void
    {
        $data = [
            'name' => 'Brenda',
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->field('name')->alpha();
        $validator->execute();

        $this->assertEquals(['name' => 'Brenda'], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException|JsonException
     */
    public function testIfCorrectJSONStringIsReturnedWhenUsingJSONResponse(): void
    {
        $data = [
            'name' => 'Brenda',
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->field('name')->alpha();
        $validator->field('age')->between(25, 100);
        $validator->execute();

        $this->assertEquals(json_encode($data, JSON_THROW_ON_ERROR), $validator->validatedData()->toJson());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenSubDataFieldIsValidated(): void
    {
        $data = [
            'people' => ['name' => 'Brenda', 'age' => 67]
        ];

        $validator = new Validator($data);
        $validator->field('people')->isArray();
        $validator->execute();

        $this->assertEquals(['people' => ['name' => 'Brenda', 'age' => 67]], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenNonOfTheDataIsValidated(): void
    {
        $data = [
            'people' => ['name' => 'Brenda', 'age' => 67]
        ];

        $validator = new Validator($data);
        $validator->field('non-existing')->alpha();
        $validator->execute();

        $this->assertEquals([], $validator->validatedData()->toArray());
    }

    public function testIfCorrectArrayIsReturnedWhenValidatorIsNotExecuted(): void
    {
        $data = [
            'people' => ['name' => 'Brenda', 'age' => 67]
        ];

        $validator = new Validator($data);

        $this->assertEquals([], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenFilteringOutFields(): void
    {
        $data = [
            'people' => [
                ['name' => 'Smith', 'age' => 52],
                ['name' => 'Morris', 'age' => 67],
            ]
        ];

        $validator = new Validator($data);
        $validator->field('people.*.age')->min(60);
        $validator->field('people.*.name')->alpha();
        $validator->execute();

        $output = [
            'people' => [
                ['name' => 'Smith'],
                ['name' => 'Morris']
            ]
        ];

        $this->assertEquals($output, $validator->validatedData()->not('people.*.age')->toArray());
        $this->assertEquals($output, $validator->validatedData()->only('people.*.name')->toArray());
        $this->assertEquals($data, $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingNonExistingFieldNamesForFiltering(): void
    {
        $data = [
            'name' => 'Brenda',
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->field('name')->alpha();
        $validator->field('age')->between(0, 100);
        $validator->execute();

        $this->assertEquals(['name' => $data['name']], $validator->validatedData()->only('name', 'non-existing', 'also-non-existing')->toArray());
        $this->assertEquals(['name' => $data['name']], $validator->validatedData()->not('age', 'non-existing', 'also-non-existing')->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenPluckingFieldNames(): void
    {
        $data = [
            'people' => [
                ['name' => 'Smith', 'age' => 52],
                ['name' => 'Morris', 'age' => 67],
            ],
        ];

        $validator = new Validator($data);
        $validator->field('people.*.age')->min(60);
        $validator->field('people.*.name')->alpha();
        $validator->execute();

        $this->assertEquals([52, 67], $validator->validatedData()->pluck('*.*.age')->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingCombine(): void
    {
        $data = [
            'name' => 'Brenda',
            'day' => 28,
            'month' => 3,
            'year' => 1952,
        ];

        $validator = new Validator($data);
        $validator->combine('day', 'month', 'year')->glue('-')->alias('date');
        $validator->field('date')->date('Y-j-d');
        $validator->field('name')->alpha();
        $validator->execute();

        $output = [
            'name' => $data['name'],
            'date' => '28-3-1952',
        ];

        $this->assertEquals($output, $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingCombineAndFiltering(): void
    {
        $data = [
            'year' => 1952,
            'month' => 3,
            'day' => 28,
            'name' => 'Brenda',
        ];

        $validator = new Validator($data);
        $validator->combine('day', 'month', 'year')->glue('-')->alias('date');
        $validator->field('date')->date('Y-j-d');
        $validator->field('name')->alpha();
        $validator->execute();

        $output = [
            'date' => '28-3-1952',
        ];

        $this->assertEquals($output, $validator->validatedData()->only('date')->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingEmptyFilter(): void
    {
        $data = [
            'foo' => '',
            'bar' => [],
            'bazz' => null,
            'quez' => ' ',
            'boaz' => 'foo',
        ];

        $validator = new Validator($data);
        $validator->field('foo', 'bar', 'bazz', 'quez', 'boaz')->required(false);
        $validator->execute();

        $this->assertSame(['quez' => ' ', 'boaz' => 'foo'], $validator->validatedData()->filter()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingEmptyStringFilter(): void
    {
        $data = [
            'foo' => '',
            'bar' => null,
            'quez' => [],
            'bazz' => 'test',
        ];

        $validator = new Validator($data);
        $validator->field('foo', 'bar', 'quez', 'bazz')->required(false);
        $validator->execute();

        $this->assertSame(['bar' => null, 'quez' => [], 'bazz' => 'test'], $validator->validatedData()->filter(ValidatedData::FILTER_EMPTY_STRINGS)->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingEmptyNullFilter(): void
    {
        $data = [
            'foo' => '',
            'bar' => null,
            'quez' => [],
            'bazz' => 'test',
        ];

        $validator = new Validator($data);
        $validator->field('foo', 'bar', 'quez', 'bazz')->required(false);
        $validator->execute();

        $this->assertSame(['foo' => '', 'quez' => [], 'bazz' => 'test'], $validator->validatedData()->filter(ValidatedData::FILTER_NULL)->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingEmptyArrayFilter(): void
    {
        $data = [
            'foo' => '',
            'bar' => null,
            'quez' => [],
            'bazz' => 'test',
        ];

        $validator = new Validator($data);
        $validator->field('foo', 'bar', 'quez', 'bazz')->required(false);
        $validator->execute();

        $this->assertSame(['foo' => '', 'bar' => null, 'bazz' => 'test'], $validator->validatedData()->filter(ValidatedData::FILTER_EMPTY_ARRAYS)->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingMultipleEmptyFilters(): void
    {
        $data = [
            'foo' => '',
            'bar' => null,
            'quez' => [],
            'bazz' => 'test',
        ];

        $validator = new Validator($data);
        $validator->field('foo', 'bar', 'quez', 'bazz')->required(false);
        $validator->execute();

        $this->assertSame(['bar' => null, 'bazz' => 'test'], $validator->validatedData()->filter(ValidatedData::FILTER_EMPTY_ARRAYS | ValidatedData::FILTER_EMPTY_STRINGS)->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingEmptyFilterWithRecursion(): void
    {
        $data = [
            'foo' => [
                '', null , [], 'bar', ' '
            ],
        ];

        $validator = new Validator($data);
        $validator->field('foo')->required(false);
        $validator->execute();

        $this->assertSame(['foo' => [3 => 'bar', 4 => ' ']], $validator->validatedData()->filter()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectArrayIsReturnedWhenUsingEmptyFilterWithoutRecursion(): void
    {
        $data = [
            'foo' => [
                '', null , [], 'bar', ' '
            ],
            'bar' => null,
            'bazz' => '',
            'quez' => []
        ];

        $validator = new Validator($data);
        $validator->field('foo')->required(false);
        $validator->execute();

        $this->assertSame(['foo' => ['', null , [], 'bar', ' ']], $validator->validatedData()->filter(ValidatedData::FILTER_EMPTY, false)->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidatedDataIsConvertedToEmptyWhenValidationPasses(): void
    {
        $data = [
            'foo' => ['', null, [], 'bar']
        ];

        $validator = new Validator($data);
        $validator->field('foo')->required(false);
        $validator->execute();

        $this->assertSame(['foo' => [null, null, null, 'bar']], $validator->validatedData()->convertEmpty()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfTemplateReturnsCorrectStructureWhenUsingNestedArray(): void
    {
        $data = [
            'foo' => 'bar',
            'quez' => [
                'first' => '1',
                'second' => [
                    'a' => '1',
                    'b' => '2',
                    'c' => '3'
                ],
                'third' => '3',
                'fourth' => '4'
            ],
            'bar' => 'baz'
        ];

        $validator = new Validator($data);
        $validator->field('foo', 'bar')->isString();
        $validator->field('quez')->isArray();

        $this->assertTrue($validator->execute());

        $output = $validator->validatedData()->template([
            'foo',
            'quez' => [
                'first',
                'second' => [
                    'b'
                ],
                'fourth'
            ]
        ])->toArray();

        $this->assertSame([
            'foo' => 'bar',
            'quez' => [
                'first' => '1',
                'second' => [
                    'b' => '2',
                ],
                'fourth' => '4'
            ]
        ], $output);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfTemplateReturnsCorrectStructureWhenUsingWildcards(): void
    {
        $data = [
            'countries' => [
                'netherlands' => [
                    'buildings' => [
                        'foo',
                        'bar'
                    ]
                ],
                'england' => [
                    'buildings' => [
                        'foo',
                        'bar'
                    ]
                ]
            ],
            'addresses' => [
                [
                    'street' => 'street 1',
                    'city' => 'city 1',
                    'zip_code' => 'zipcode 1',
                    'house_number' => 'house number 1',
                ],
                [
                    'street' => 'street 2',
                    'city' => 'city 2',
                    'zip_code' => 'zipcode 2',
                    'house_number' => 'house number 2',
                ]
            ]
        ];

        $validator = new Validator($data);
        $validator->field('countries', 'addresses')->isArray();

        $this->assertTrue($validator->execute());

        $output = $validator->validatedData()->template([
            'countries' => [
                '*' => [
                    'buildings'
                ]
            ],
            'addresses' => [
                '*' => [
                    'zip_code',
                    'house_number'
                ]
            ]
        ])->toArray();

        $this->assertSame([
            'countries' => [
                'netherlands' => [
                    'buildings' => [
                        'foo',
                        'bar'
                    ]
                ],
                'england' => [
                    'buildings' => [
                        'foo',
                        'bar'
                    ]
                ]
            ],
            'addresses' => [
                [
                    'zip_code' => 'zipcode 1',
                    'house_number' => 'house number 1',
                ],
                [
                    'zip_code' => 'zipcode 2',
                    'house_number' => 'house number 2',
                ]
            ]
        ], $output);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfTemplateReturnsCorrectStructureWhenUsingFlatArray(): void
    {
        $data = [
            'foo' => [
                'a' => '1',
                'b' => '2',
                'c' => '3'
            ]
        ];

        $validator = new Validator($data);
        $validator->field('foo')->isArray();

        $this->assertTrue($validator->execute());

        $output = $validator->validatedData()->template(['foo'])->toArray();

        $this->assertSame([
            'foo' => [
                'a' => '1',
                'b' => '2',
                'c' => '3'
            ]
        ], $output);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfTemplateReturnsCorrectStructureWhenTargetingNonExistingFields(): void
    {
        $data = ['foo' => 'bar'];

        $validator = new Validator($data);
        $validator->field('foo')->isString();

        $this->assertTrue($validator->execute());

        $output = $validator->validatedData()->template(['foo' => ['a', 'b']])->toArray();

        $this->assertSame([], $output);
    }

    /**
     * @throws ValidatorException
     */
    public function testIfTemplateReturnsEmptyArrayWhenProvidingEmptyArray(): void
    {
        $data = ['foo' => 'bar'];

        $validator = new Validator($data);
        $validator->field('foo')->isString();

        $this->assertTrue($validator->execute());

        $output = $validator->validatedData()->template([])->toArray();

        $this->assertSame([], $output);
    }
}
