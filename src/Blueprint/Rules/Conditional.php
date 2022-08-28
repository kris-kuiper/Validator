<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Closure;
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Conditional extends AbstractRule
{
    /**
     * @inheritdoc
     */
    protected string $message = 'Invalid value';

    /**
     * Constructor
     */
    public function __construct(Closure $callback)
    {
        $this->setParameter('callback', $callback);
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'conditional';
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $callback = $this->getParameter('callback');
        $conditional = $callback(new Current($this, $this->getName()));

        if (false === $conditional) {
            $this->getField()?->setBailed(true);
        }

        return true;
    }
}
