<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class Accepted extends AbstractRule
{
    public const NAME = 'accepted';

    /**
     * @inheritdoc
     */
    protected string|int|float $message = 'Should be accepted';

    private array $accepted = ['yes', 'on', '1', 'true', 1, true];

    /**
     * Constructor
     */
    public function __construct(array $accepted = [])
    {
        parent::__construct();

        if (0 !== count($accepted)) {
            $this->accepted = $accepted;
        }

        $this->setParameter('accepted', $this->accepted);
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
        return true === in_array($this->getValue(), $this->accepted, true);
    }
}
