<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsTimezone extends AbstractRule
{
    public const NAME = 'isTimezone';

    /**
     * @inheritdoc
     */
    protected string $message = 'Not a valid timezone';

    /**
     * Constructor
     */
    public function __construct(bool $caseInsensitive = false)
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
        $caseInsensitive = $this->getParameter('caseInsensitive');

        if (true === $caseInsensitive) {
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
