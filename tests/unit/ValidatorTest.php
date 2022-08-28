<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Rules\Between;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;
use tests\unit\assets\LeadingZeroMiddleware;

final class ValidatorTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingMiddleware(): void
    {
        $data = [
            'month' => 3,
        ];

        $validator = new Validator($data);
        $validator->middleware('month')->load(new LeadingZeroMiddleware());
        $validator->field('month');

        $this->assertTrue($validator->execute());
        $this->assertSame(['month' => '03'], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingMiddlewareWithoutUsingField(): void
    {
        $data = [
            'month' => 3,
        ];

        $validator = new Validator($data);
        $validator->middleware('month')->load(new LeadingZeroMiddleware());

        $this->assertTrue($validator->execute());
        $this->assertSame(['month' => '03'], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectValidatedDataIsReturnedWhenUsingMultipleFieldsAndMiddleware(): void
    {
        $data = [
            'day' => '2',
            'month' => '5',
            'year' => '1952'
        ];

        $validator = new Validator($data);
        $validator->combine('year', 'month', 'day')->glue('-')->alias('date');
        $validator->middleware('month', 'day')->load(new LeadingZeroMiddleware());
        $validator->field('date')->required()->isDate();

        $this->assertTrue($validator->execute());
        $this->assertSame(['date' => '1952-05-02'], $validator->validatedData()->only('date')->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectValuesForErrorMessageWhenObtainingError(): void
    {
        $data = ['foo' => 11];
        $validator = new Validator($data);
        $validator->field('foo')->between(0, 10);
        $validator->execute();

        $errors = $validator->errors();
        $error = $errors->current();

        $this->assertSame(1, $errors->count());
        $this->assertSame($error->getParameters(), ['minimum' => 0.0, 'maximum' => 10.0]);
        $this->assertSame(Between::NAME, $error->getRuleName());
        $this->assertSame($data['foo'], $error->getValue());
        $this->assertIsString($error->getId());
        $this->assertIsString($error->getRawMessage());
        $this->assertIsString($error->getMessage());
    }


    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectErrorMessageWhenUsingCustomErrorsMessagesPerField(): void
    {
        $data = [
            'product' => [
                'option 1',
                'option 2',
                'option 3',
            ]
        ];

        $rawMessage = 'Maximum of :amount options per product';
        $message = 'Maximum of 2 options per product';

        $validator = new Validator($data);
        $validator->field('product')->countMax(2);
        $validator->messages('product')->countMax($rawMessage);

        $this->assertFalse($validator->execute());
        $this->assertSame($message, $validator->errors()->current()->getMessage());
        $this->assertSame($rawMessage, $validator->errors()->current()->getRawMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectAmountOfErrorsWhenUsingDistinctMethod(): void
    {
        $data = ['username' => 'abc', 'password' => '123', 'password_repeat' => '456'];

        $validator = new Validator($data);
        $validator->field('username')->between(5, 10)->startsWith('def');
        $validator->field('password')->same('password_repeat');
        $validator->execute();

        $this->assertCount(3, $validator->errors());
        $this->assertCount(2, $validator->errors()->distinct());
    }


    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCorrectErrorMessageWhenUsingCustomErrorsMessages(): void
    {
        $data = [
            'product' => [
                'option 1',
                'option 2',
                'option 3',
            ]
        ];

        $rawMessage = 'Maximum of :amount options per product';
        $message = 'Maximum of 2 options per product';

        $validator = new Validator($data);
        $validator->field('product')->countMax(2);
        $validator->messages()->countMax($rawMessage);

        $this->assertFalse($validator->execute());
        $this->assertSame($message, $validator->errors()->current()->getMessage());
        $this->assertSame($rawMessage, $validator->errors()->current()->getRawMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testShouldReturnCustomErrorMessageWhenMultipleFieldsAreUsingItWithDifferentParameters(): void
    {
        $data = [
            'product1' => [
                'option 1',
                'option 2',
                'option 3',
            ],
            'product2' => [
                'option 1',
                'option 2',
                'option 3',
                'option 4',
            ],
        ];

        $validator = new Validator($data);
        $validator->field('product1')->countMax(2);
        $validator->field('product2')->countMax(3);
        $validator->messages()->countMax('Maximum of :amount options per product');

        $this->assertFalse($validator->execute());

        $errors = $validator->errors();
        $this->assertSame('Maximum of 2 options per product', $errors->current()->getMessage());

        $errors->next();
        $this->assertSame('Maximum of 3 options per product', $errors->current()->getMessage());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingWildCardFields(): void
    {
        $data = [
            'people' => [
                [
                    'name' => 'Morris',
                    'age' => 15
                ],
                [
                    'name' => 'Smith',
                    'age' => 14
                ],
            ],
            'animals' => [
                [
                    'name' => 'Boefje',
                    'age' => 13
                ],
                [
                    'name' => 'Crock',
                    'age' => 12
                ]
            ],
            'humans' => [
                [
                    'name' => 'John',
                    'age' => 11
                ],
                [
                    'name' => 'Williams',
                    'age' => 10
                ]
            ],
            'buildings' => [
                [
                    'name' => 'Colosseum',
                    'age' => 11
                ],
                [
                    'name' => 'Pantheon',
                    'age' => 10
                ]
            ]
        ];

        $validator = new Validator($data);
        $validator->field('*.*.age')->min(18);
        $validator->messages('people.*.age', 'humans.*.age')->min('Person :minimum');
        $validator->messages('animals.*.age')->min('Animal :minimum');
        $validator->messages()->min('Item :minimum');

        $this->assertFalse($validator->execute());

        $errors = $validator->errors();

        $this->assertSame('Person 18', $errors->get('people.*.age')->current()->getMessage());
        $this->assertSame('Person 18', $errors->get('people.*.*')->current()->getMessage());
        $this->assertSame('Person 18', $errors->get('humans.*.age')->current()->getMessage());
        $this->assertSame('Person 18', $errors->get('humans.*.*')->current()->getMessage());
        $this->assertSame('Animal 18', $errors->get('animals.*.age')->current()->getMessage());
        $this->assertSame('Animal 18', $errors->get('animals.*.*')->current()->getMessage());
        $this->assertSame('Item 18', $errors->get('buildings.*.age')->current()->getMessage());
        $this->assertSame('Item 18', $errors->get('buildings.*.*')->current()->getMessage());
        $this->assertNull($errors->get('non-existing.*.age')->current());
        $this->assertNull($errors->get('non-existing.*.*')->current());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfCorrectAmountOfErrorsReturnsWhenUsingGetMethod(): void
    {
        $data = [
            'people' => [
                'name' => 'Morris',
                'age' => 15
            ],
            'animal' => [
                'name' => 'Boefje',
                'age' => 3
            ]
        ];

        $validator = new Validator($data);
        $validator->field('*.age')->min(18);

        $this->assertFalse($validator->execute());
        $this->assertCount(2, $validator->errors()->get('*.age'));
        $this->assertCount(1, $validator->errors()->get('people.age'));
        $this->assertCount(1, $validator->errors()->get('animal.age'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorsReturnsWhenUsingHasMethod(): void
    {
        $data = [
            'people' => [
                'name' => 'Morris',
                'age' => 15
            ],
            'animal' => [
                'name' => 'Boefje',
                'age' => 3
            ]
        ];

        $validator = new Validator($data);
        $validator->field('*.age')->min(18);

        $this->assertFalse($validator->execute());
        $this->assertTrue($validator->errors()->has('*.age'));
        $this->assertTrue($validator->errors()->has('people.age'));
        $this->assertTrue($validator->errors()->has('animal.age'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenMinimumAgeIsNotSatisfied(): void
    {
        $data = [
            'people' => [
                'name' => 'Morris',
                'age' => 15
            ],
            'animal' => [
                'name' => 'Boefje',
                'age' => 3
            ]
        ];

        $validator = new Validator($data);
        $validator->field('*.age')->min(18);

        $this->assertFalse($validator->execute());
        $this->assertNotNull($validator->errors()->first('people.age'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessagesAreReturnedWhenValidationFailsUsingWildCards(): void
    {
        $data = [
            'people' => [
                'name' => 'Morris',
                'age' => 15
            ],
            'animal' => [
                'name' => 'Boefje',
                'age' => 3
            ]
        ];

        $validator = new Validator($data);
        $validator->field('*.age')->min(18);
        $validator->messages('*.age')->min('Minimum :minimum years old');

        $this->assertFalse($validator->execute());

        $error = $validator->errors()->first('people.age');
        $path = $error->getPath();

        $this->assertSame('Minimum 18 years old', $error->getMessage());
        $this->assertSame('Minimum :minimum years old', $error->getRawMessage());
        $this->assertSame('min', $error->getRuleName());
        $this->assertSame(15, $error->getValue());
        $this->assertSame(['minimum' => 18.0], $error->getParameters());
        $this->assertSame('people.age', $path->getIdentifier());
        $this->assertSame(15, $path->getValue());
        $this->assertSame(['people', 'age'], $path->getPath());
    }




    /**
     * @throws ValidatorException
     */
//    public function testShouldReturnCorrectAmountOfErrorsWhenUsingDistinctMethodAndWildcards(): void
//    {
//        $data = [
//            'product' => [
//                'option 1',
//            ]
//        ];
//
//        $validator = new Validator($data);
//        $validator->field('product.1')->endsWith('bar');
//        $validator->field('product.*')->between(1, 5)->startsWith('foo');
//        $validator->execute();
//
//        foreach ($validator->errors()->distinct() as $error) {
//            var_dump($error->getFieldName(), $error->getMessage());
//        }
//
//        exit();
//        $this->assertCount(3, $validator->errors());
//        $this->assertCount(2, $validator->errors()->distinct());
//    }

    /**
     * @throws ValidatorException
     */
}
