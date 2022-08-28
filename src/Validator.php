<?php

declare(strict_types=1);

namespace KrisKuiper\Validator;

use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Combine\Combine;
use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Custom\Custom;
use KrisKuiper\Validator\Blueprint\MessageList;
use KrisKuiper\Validator\Blueprint\MiddlewareList;
use KrisKuiper\Validator\Middleware\Field as MiddlewareField;
use KrisKuiper\Validator\Blueprint\FieldOptions;
use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Blueprint\Rules\Custom as CustomRule;
use KrisKuiper\Validator\Collections\ErrorCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Parser\BlueprintParser;
use KrisKuiper\Validator\Translator\Path;
use KrisKuiper\Validator\Translator\PathTranslator;

class Validator
{
    private bool $isValidated = false;
    private bool $isValid = true;
    private PathTranslator $validationData;
    private BlueprintParser $blueprintParser;
    private Blueprint $blueprint;
    private ValidatedData $validatedData;
    private ErrorCollection $errorCollection;

    /**
     * Constructor
     */
    public function __construct(array $validationData = [])
    {
        $this->validationData = new PathTranslator($validationData);
        $this->errorCollection = new ErrorCollection();
        $this->validatedData = new ValidatedData();

        $this->blueprint = new Blueprint();
        $this->blueprintParser = new BlueprintParser($this->validationData);
        $this->blueprintParser->getBlueprintCollection()->append($this->blueprint);
    }

    /**
     * Adds new field validation
     */
    public function field(string ...$fieldNames): FieldOptions
    {
        return $this->blueprint->field(...$fieldNames);
    }

    /**
     * Combines fields into one for validating this new value as one
     */
    public function combine(string ...$fieldNames): Combine
    {
        return $this->blueprint->combine(...$fieldNames);
    }

    /**
     * Sets custom error messages per rule en/or per field and rule
     */
    public function messages(string ...$fieldNames): MessageList
    {
        return $this->blueprint->messages(...$fieldNames);
    }

    /**
     * Adds new middleware for one or more field names which runs before validation
     */
    public function middleware(string ...$fieldNames): MiddlewareList
    {
        return $this->blueprint->middleware(...$fieldNames);
    }

    /**
     * Loads a custom rule
     */
    public function loadRule(RuleInterface $rule, string $alias = null): void
    {
        $this->blueprint->loadRule($rule, $alias);
    }

    /**
     * Loads a blueprint for extending/inheritance other validators
     */
    public function loadBlueprint(Blueprint ...$blueprints): void
    {
        foreach ($blueprints as $blueprint) {
            $this->blueprintParser->getBlueprintCollection()->prepend($blueprint);
        }
    }

    /**
     * Creates a new rule with a user defined callback which will be validated calling the provided rule name
     */
    public function custom(string $ruleName, callable $callback): Custom
    {
        return $this->blueprint->custom($ruleName, $callback);
    }

    /**
     * Returns the error bag
     */
    public function errors(): ErrorCollection
    {
        return $this->errorCollection;
    }

    /**
     * Returns all the validated data
     */
    public function validatedData(): ValidatedData
    {
        return $this->validatedData;
    }

    /**
     * Resets the cache of the validator
     */
    public function reset(): self
    {
        $this->isValid = true;
        $this->isValidated = false;

        return $this;
    }

    /**
     * Returns whenever the validation failed or not
     * @throws ValidatorException
     */
    public function fails(): bool
    {
        return false === $this->execute();
    }

    /**
     * Returns whenever the validation passes or not
     * @throws ValidatorException
     */
    public function passes(): bool
    {
        return true === $this->execute();
    }

    /**
     * Executes all the given validation rules for all given fields and returns if validation passes or not
     * @throws ValidatorException
     */
    public function execute(): bool
    {
        //Check if validation already executed before
        if (true === $this->isValidated) {
            return $this->isValid;
        }

        $this->blueprintParser->getFieldCollection()->each(function (Field $field) {

            $this->executeMiddleware($field);
            $this->addValidatedData($field);

            $field->getFieldOptions()->each(function (FieldOptions $fieldOption) use ($field) {

                $field->setBailed(false);

                $fieldOption->getRules()->each(function (AbstractRule $rule) use ($field) {

                    $rule = clone $rule;

                    if (true === $field->isBailed()) {
                        return false;
                    }

                    $rule->setValidationData($this->validationData);
                    $rule->setField($field);

                    //Check if the rule is valid or not
                    if (true === $this->executeRule($rule)) {
                        return true;
                    }

                    $this->isValid = false;
                    $this->addValidationError($rule);

                    //If the rule is not valid and all the other rules for the field group should be bailed, stop the loop
                    if (true === $rule->shouldBail() || true === $field->getShouldBail()) {
                        $field->setBailed(true);
                        return false;
                    }

                    return true;
                });
            });
        });

        return $this->isValid;
    }

    /**
     * Executes a single given rule and returns if the validation passed or not
     * @throws ValidatorException
     */
    private function executeRule(AbstractRule $rule): bool
    {
        if ($rule instanceof CustomRule) {
            $ruleName = $rule->getName();
            $custom = $this->blueprintParser->getCustomCollection()->getByRuleName($ruleName);

            if (null === $custom) {
                throw ValidatorException::customRuleNotFound($ruleName);
            }

            $rule->setCallback($custom->getCallback());
        }

        //Check if the rule is valid or not
        return $rule->isValid();
    }

    /**
     * Executes middleware for a provided field
     */
    private function executeMiddleware(Field $field): void
    {
        foreach ($field->getMiddleware() as $middleware) {
            $middleware->invoke()->handle(new MiddlewareField($field));
        }
    }

    /**
     * Adds the value of validated fields
     * @throws ValidatorException
     */
    private function addValidatedData(Field $field): void
    {
        if ('' !== $field->getPath()->getIdentifier()) {
            $this->validatedData->add($field->getPath());
        }

        //Check if field is part of a combine. All fields in the combine should be added too.
        if ($combineProxy = $this->blueprintParser->getCombineProxyCollection()->getByAlias($field->getFieldName())) {
            $combine = $combineProxy->getProxy();
            $this->validatedData->add(new Path([$combine->getAlias()], $combineProxy->getValue()));
        }
    }

    /**
     * Adds a new validation error
     */
    private function addValidationError(AbstractRule $rule): void
    {
        $messageCollection = $this->blueprintParser->getMessageCollection();
        $message = $messageCollection->getRuleCollection()->filterByName($rule->getName());

        if (null !== $message) {
            $rule->setMessage($message->getMessage());
        }

        $messageCollection->getFieldCollection()->each(function ($rules, $identifier) use ($rule) {

            $errorMessage = $rules[$rule->getName()] ?? null;

            if (null === $errorMessage) {
                return true;
            }

            if (true === $rule->getField()?->match($identifier) || true === $rule->getField()?->getPath()->match($identifier)) {
                $rule->setMessage($errorMessage);
                return false;
            }

            return true;
        });

        $error = new Error($rule);
        $this->errorCollection->append($error);
    }
}
