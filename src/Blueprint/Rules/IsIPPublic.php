<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Translator\Path;

class IsIPPublic extends AbstractRule
{
    public const NAME = 'isIPPublic';

    /**
     * @inheritdocs
     */
    protected string $message = 'Must be a public IP address';

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

        $ip = new IsIP();
        $ip->setField($field);

        if (true === $ip->isValid()) {
            return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE);
        }

        return false;
    }
}
