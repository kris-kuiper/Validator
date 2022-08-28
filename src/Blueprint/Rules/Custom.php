<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Rules;

use Closure;
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Exceptions\ValidatorException;

class Custom extends AbstractRule
{
    /**
     * @inheritdoc
     */
    protected string $message = 'Invalid value';

    /**
     * Contains the callback which is executed on validation
     */
    private ?Closure $callback = null;

    /**
     * Constructor
     */
    public function __construct(private string $name, array $parameters = [])
    {
        parent::__construct();

        foreach ($parameters as $parameterName => $value) {
            $this->setParameter($parameterName, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets a new callback which should be executed on validation
     */
    public function setCallback(Closure $callback): void
    {
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     * @throws ValidatorException
     */
    public function isValid(): bool
    {
        $callback = $this->callback;

        if (null === $callback) {
            throw ValidatorException::customRuleCallbackNotSet($this->name);
        }

        return $callback(new Current($this, $this->getName()));
    }
}
