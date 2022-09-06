<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class IPPrivate extends AbstractRule
{
    public const NAME = 'ipPrivate';

    /**
     * @inheritdocs
     */
    protected string $message = 'Must be a private IP address';

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

        $ip = new IP();
        $ip->setField($field);

        if (false === $ip->isValid()) {
            return false;
        }

        $ipPublic = new IPPublic();
        $ipPublic->setField($field);

        return false === $ipPublic->isValid();
    }
}
