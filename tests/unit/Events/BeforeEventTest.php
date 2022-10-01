<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Events\BeforeEvent;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;
use tests\unit\assets\CustomBeforeEventHandler;

final class BeforeEventTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfBeforeEventWhenValidationIsExecuted(): void
    {
        $data = [
            'product' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
            ],
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->before(function (BeforeEvent $event) use ($data) {

            $this->assertTrue($event->field('age')->isInt()->isValid());
            $this->assertSame($data, $event->getValidationData());

            $ids = $event->getValue('product.*.id');
            $event->storage()->set('ids', $ids);
        });

        $validator->execute();
        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfBeforeEventWhenUsingBlueprints(): void
    {
        $blueprint = new Blueprint();
        $blueprint->before(function (BeforeEvent $event) {

            $this->assertTrue($event->field('age')->isInt()->isValid());
            $ids = $event->getValue('product.*.id');
            $event->storage()->set('ids', $ids);
        });

        $data = [
            'product' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
            ],
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->loadBlueprint($blueprint);
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfBeforeEventHandlerObjectIsExecutedWhenValidationIsExecuted(): void
    {
        $data = [
            'product' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
            ],
            'age' => 67
        ];

        $validator = new Validator($data);
        $validator->loadBeforeEvent(new CustomBeforeEventHandler());
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfBeforeEventHandlerObjectIsExecutedWhenUsingBlueprint(): void
    {
        $data = [
            'product' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
            ],
            'age' => 67
        ];

        $blueprint = new Blueprint();
        $blueprint->loadBeforeEvent(new CustomBeforeEventHandler());

        $validator = new Validator($data);
        $validator->loadBlueprint($blueprint);
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }
}
