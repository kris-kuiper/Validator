<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class IsUUID extends AbstractRule
{
    public const NAME = 'isUUID';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be a valid v1, v3, v4 or v5 UUID string';

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $value = $this->getValue();
        $field = new Field(new Path(['uuid'], $value), 'uuid', new CombineProxyCollection());

        $uuidv1 = new IsUUIDv1();
        $uuidv1->setField($field);

        $uuidv3 = new IsUUIDv3();
        $uuidv3->setField($field);

        $uuidv4 = new IsUUIDv4();
        $uuidv4->setField($field);

        $uuidv5 = new IsUUIDv5();
        $uuidv5->setField($field);

        return true === ($uuidv1->isValid() || $uuidv3->isValid() || $uuidv4->isValid() || $uuidv5->isValid());
    }
}
