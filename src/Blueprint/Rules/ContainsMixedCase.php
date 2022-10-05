<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class ContainsMixedCase extends AbstractRule
{
    public const NAME = 'containsMixedCase';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Requires at least :lowercaseCount uppercase and uppercaseCount: lowercase letter(s)';

    public function __construct(private int $minimumLowercaseCount = 1, private int $minimumUppercaseCount = 1)
    {
        parent::__construct();
        $this->setParameter('lowercaseCount', $this->minimumLowercaseCount);
        $this->setParameter('uppercaseCount', $this->minimumUppercaseCount);
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

        if (false === is_string($value)) {
            return false;
        }

        preg_match_all('/([a-z])/', $value, $lowercaseCount);
        preg_match_all('/([A-Z])/', $value, $uppercaseCount);

        return count($lowercaseCount[0] ?? []) >= $this->minimumLowercaseCount && count($uppercaseCount[0] ?? []) >= $this->minimumUppercaseCount;
    }
}
