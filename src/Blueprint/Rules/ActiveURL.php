<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Exception;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class ActiveURL extends AbstractRule
{
    public const NAME = 'activeURL';

    /**
     * @inheritdocs
     */
    protected string|int|float $message = 'Should be an active URL';

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

        if (false === is_string($value)) {
            return false;
        }

        $url = parse_url($value, PHP_URL_HOST);

        if (false === $url) {
            return false;
        }

        try {
            $records = dns_get_record($value, DNS_AAAA | DNS_A);

            if (is_array($records) && count($records) > 0) {
                return true;
            }
        } catch (Exception) {
        }

        return false;
    }
}
