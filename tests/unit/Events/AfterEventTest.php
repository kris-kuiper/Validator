<?php

declare(strict_types=1);

namespace tests\unit;

use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Events\AfterEvent;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Validator;
use PHPUnit\Framework\TestCase;
use tests\unit\assets\CustomAfterEventHandler;

final class AfterEventTest extends TestCase
{
    /**
     * @throws ValidatorException
     */
    public function testIfAfterEventWhenValidationIsExecuted(): void
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
        $validator->after(function (AfterEvent $event) use ($data): void {

            $this->assertTrue($event->passed());
            $this->assertFalse($event->failed());
            $this->assertCount(0, $event->errors());
            $this->assertSame($data, $event->getValidationData());
            $this->assertSame(['product' => $data['product']], $event->getValidatedData()->toArray());

            $ids = $event->getValue('product.*.id');
            $event->storage()->set('ids', $ids);
        });

        $validator->field('product.*.id')->required()->isInt();
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfAfterEventWhenUsingBlueprints(): void
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
        $blueprint->after(function (AfterEvent $event) use ($data): void {

            $this->assertTrue($event->passed());
            $this->assertFalse($event->failed());
            $this->assertCount(0, $event->errors());
            $this->assertSame($data, $event->getValidationData());
            $this->assertSame(['product' => $data['product']], $event->getValidatedData()->toArray());

            $ids = $event->getValue('product.*.id');
            $event->storage()->set('ids', $ids);
        });

        $validator = new Validator($data);
        $validator->loadBlueprint($blueprint);
        $validator->field('product.*.id')->required()->isInt();
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfAfterEventHandlerObjectIsExecutedWhenValidationIsExecuted(): void
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
        $validator->loadAfterEvent(new CustomAfterEventHandler());
        $validator->field('product.*.id')->required()->isInt();
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }

    /**
     * @throws ValidatorException
     */
    public function testIfAfterEventHandlerObjectIsExecutedWhenUsingBlueprint(): void
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
        $blueprint->loadAfterEvent(new CustomAfterEventHandler());

        $validator = new Validator($data);
        $validator->loadBlueprint($blueprint);
        $validator->field('product.*.id')->required()->isInt();
        $validator->execute();

        $this->assertTrue($validator->storage()->has('ids'));
        $this->assertSame([1, 2, 3, 4], $validator->storage()->get('ids'));
    }
}
