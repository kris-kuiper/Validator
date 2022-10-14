<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Timezone extends AbstractRule
{
    public const NAME = 'timezone';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Not a valid timezone';

    /**
     * Constructor
     */
    public function __construct(private bool $caseInsensitive = false)
    {
        parent::__construct();
        $this->setParameter('caseInsensitive', $caseInsensitive);
    }

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
        $timezones = timezone_identifiers_list();

        if (true === $this->caseInsensitive) {
            $timezones = array_map(static function (string $timezone) {
                return strtolower($timezone);
            }, $timezones);

            if (true === is_string($value)) {
                $value = strtolower($value);
            }
        }

        return true === in_array($value, $timezones, true);
    }
}
