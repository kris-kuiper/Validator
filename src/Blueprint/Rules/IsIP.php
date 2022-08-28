<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class IsIP extends AbstractRule
{
    public const NAME = 'isIP';

    /**
     * @inheritdocs
     */
    protected string $message = 'Value should be a valid IP address (V4 or V6)';

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
        $field = new Field(new Path(['ip'], $value), 'ip', new CombineProxyCollection());

        $ipv4 = new IsIPv4();
        $ipv4->setField($field);

        $ipv6 = new IsIPv6();
        $ipv6->setField($field);

        return true === ($ipv4->isValid() || $ipv6->isValid());
    }
}
