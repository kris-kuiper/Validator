<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use KrisKuiper\Validator\Exceptions\ValidatorException;

class IsAccepted extends AbstractRule
{
    public const NAME = 'isAccepted';

    /**
     * @inheritdoc
     */
    protected string $message = 'Should be accepted';

    /**
     * Constructor
     */
    public function __construct(array $accepted = [])
    {
        parent::__construct();
        if (0 === count($accepted)) {
            $accepted = ['yes', 'on', '1', 'true', 1, true];
        }

        $this->setParameter('accepted', $accepted);
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
        return true === in_array($this->getValue(), $this->getParameter('accepted'), true);
    }
}
