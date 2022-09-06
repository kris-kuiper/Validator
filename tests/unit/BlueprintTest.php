<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class BlueprintTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenUsingOnlyBlueprintRules(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(3);

        $validator = new Validator(['foo' => 3]);
        $validator->loadBlueprint($blueprint);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenUsingOnlyBlueprintRules(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(5);

        $validator = new Validator(['foo' => 3]);
        $validator->loadBlueprint($blueprint);

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenCombiningValidationRulesWithBlueprintRules(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(5);

        $validator = new Validator(['foo' => 8]);
        $validator->loadBlueprint($blueprint);
        $validator->field('foo')->max(7);

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenOverwritingBlueprintRules(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(5);

        $validator = new Validator(['foo' => 8]);
        $validator->loadBlueprint($blueprint);
        $validator->field('foo')->min(9);

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenLoadingBlueprintWithCombine(): void
    {
        $blueprint = new Blueprint();
        $blueprint->combine('year', 'month', 'day')->glue('-')->alias('date');
        $blueprint->field('date')->date();

        $validator = new Validator(['day' => '01', 'month' => '01', 'year' => '2000']);
        $validator->loadBlueprint($blueprint);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenLoadingBlueprintWithCombine(): void
    {
        $blueprint = new Blueprint();
        $blueprint->combine('year', 'month', 'day')->glue('-')->alias('date');
        $blueprint->field('date')->date();

        $validator = new Validator(['day' => 'a', 'month' => 'b', 'year' => 'c']);
        $validator->loadBlueprint($blueprint);

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenLoadingBlueprintWithCombineButSetTheFieldInTheValidatorInsteadOfBlueprint(): void
    {
        $blueprint = new Blueprint();
        $blueprint->combine('year', 'month', 'day')->glue('-')->alias('date');

        $validator = new Validator(['day' => '01', 'month' => '01', 'year' => '2000']);
        $validator->field('date')->date();
        $validator->loadBlueprint($blueprint);

        $this->assertTrue($validator->execute());
        $this->assertSame(['date' => '2000-01-01'], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenLoadingBlueprint(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(3);

        $validator = new Validator(['foo' => 2]);
        $validator->loadBlueprint($blueprint);

        $this->assertFalse($validator->execute());
        $this->assertSame(['foo' => 2], $validator->validatedData()->toArray());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenCombiningMultipleBlueprints(): void
    {
        $blueprint1 = new Blueprint();
        $blueprint1->field('foo')->min(2);

        $blueprint2 = new Blueprint();
        $blueprint2->field('foo')->max(5);

        $blueprint3 = new Blueprint();
        $blueprint3->field('foo')->between(2, 5);

        $validator = new Validator(['foo' => 2]);
        $validator->loadBlueprint($blueprint1, $blueprint2, $blueprint3);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectMessageIsReturnedWhenSettingMessageInBlueprint(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(3);
        $blueprint->messages('foo')->min('Minimum 3 foo\'s');

        $validator = new Validator(['foo' => 2]);
        $validator->loadBlueprint($blueprint);

        $this->assertFalse($validator->execute());
        $this->assertSame('Minimum 3 foo\'s', $validator->errors()->current()->getMessage());
    }


    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhileOverwritingBlueprintErrorMessage(): void
    {
        $blueprint = new Blueprint();
        $blueprint->field('foo')->min(3);
        $blueprint->messages('foo')->min('Minimum 3 foo\'s');

        $validator = new Validator(['foo' => 2]);
        $validator->loadBlueprint($blueprint);
        $validator->messages('foo')->min('3 foo\'s minimum');

        $this->assertFalse($validator->execute());
        $this->assertSame('3 foo\'s minimum', $validator->errors()->first('foo')->getMessage());
        $this->assertCount(1, $validator->errors());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenBlueprintCustomRuleIsProvided(): void
    {
        $blueprint = new Blueprint();
        $blueprint->custom('length', function (Current $current) {

            $this->assertSame('length', $current->getRuleName());
            $this->assertSame('foo', $current->getFieldName());
            $this->assertSame('foobar', $current->getValue());
            $this->assertSame(5, $current->getParameter('characters'));
            $this->assertSame(['characters' => 5], $current->getParameters());
            $this->assertSame(['foo' => 'foobar'], $current->getValidationData());

            return false;
        });

        $blueprint->field('foo')->custom('length', ['characters' => 5]);

        $validator = new Validator(['foo' => 'foobar']);
        $validator->loadBlueprint($blueprint);

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationFailsWhenBlueprintCustomRuleIsProvidedAndFieldIsDefinedInTheValidator(): void
    {
        $blueprint = new Blueprint();
        $blueprint->custom('length', function (Current $current) {
            return strlen($current->getValue()) === $current->getParameter('characters');
        });

        $validator = new Validator(['foo' => 'foobar']);
        $validator->loadBlueprint($blueprint);
        $validator->field('foo')->custom('length', ['characters' => 6]);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCorrectErrorMessageIsReturnedWhileUsingBlueprint(): void
    {
        $blueprint = new Blueprint();
        $blueprint->custom('length', function (Current $current) {
            return strlen($current->getValue()) === $current->getParameter('characters');
        });
        $blueprint->messages('foo')->custom('length', 'Length must be :characters characters long');

        $validator = new Validator(['foo' => 'foobar']);
        $validator->loadBlueprint($blueprint);
        $validator->field('foo')->custom('length', ['characters' => 5]);

        $this->assertfalse($validator->execute());
        $this->assertSame('Length must be 5 characters long', $validator->errors()->first('foo')->getMessage());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCombineCanBeOverwrittenWhenProvidingDuplicateAliases(): void
    {
        $blueprint = new Blueprint();
        $blueprint->combine('year', 'month', 'day')->glue('-')->alias('date');
        $blueprint->field('date')->date('Y/m/d');

        $validator = new Validator(['year' => '1952', 'month' => '03', 'day' => '28']);
        $validator->loadBlueprint($blueprint);
        $validator->combine('year', 'month', 'day')->glue('/')->alias('date');

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfCustomCanBeOverwrittenWhenProvidedDuplicateRuleName(): void
    {
        $blueprint = new Blueprint();
        $blueprint->custom('length', function (Current $current) {
            return $current->getValue() < 10;
        });
        $blueprint->field('foo')->custom('length');

        $validator = new Validator(['foo' => 5]);
        $validator->loadBlueprint($blueprint);
        $validator->custom('length', function (Current $current) {
            return $current->getValue() < 5;
        });

        $this->assertFalse($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfMiddlewareCanBeLoadedWhenUsingBlueprint(): void
    {
        $blueprint = new Blueprint();
        $blueprint->middleware('foo')->leadingZero();
        $blueprint->field('foo')->equals('05');

        $validator = new Validator(['foo' => 5]);
        $validator->loadBlueprint($blueprint);

        $this->assertTrue($validator->execute());
    }

    /**
     * @throws ValidatorException
     */
    public function testIfValidationPassesWhenMiddlewareIsMerged(): void
    {
        $blueprint = new Blueprint();
        $blueprint->middleware('foo')->trim();
        $blueprint->field('foo')->equals('A');

        $validator = new Validator(['foo' => '  a  ']);
        $validator->loadBlueprint($blueprint);
        $validator->middleware('foo')->toUppercase();

        $this->assertTrue($validator->execute());
        $this->assertSame(['foo' => 'A'], $validator->validatedData()->toArray());
    }
}
