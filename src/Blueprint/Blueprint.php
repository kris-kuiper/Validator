<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint;

use Closure;
use KrisKuiper\Validator\Blueprint\Collections\CombineCollection;
use KrisKuiper\Validator\Blueprint\Collections\CustomCollection;
use KrisKuiper\Validator\Blueprint\Collections\FieldNameCollection;
use KrisKuiper\Validator\Blueprint\Collections\MessageListCollection;
use KrisKuiper\Validator\Blueprint\Combine\Combine;
use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Blueprint\Custom\Custom;
use KrisKuiper\Validator\Blueprint\ValueObjects\FieldName;

class Blueprint
{
    private FieldNameCollection $fieldNameCollection;
    private MessageListCollection $messageListCollection;
    private CombineCollection $combineCollection;
    private CustomCollection $customCollection;

    public function __construct()
    {
        $this->fieldNameCollection = new FieldNameCollection();
        $this->messageListCollection = new MessageListCollection();
        $this->combineCollection = new CombineCollection();
        $this->customCollection = new CustomCollection();
    }

    /**
     * Returns all the field name objects as a collection
     */
    public function getFieldNames(): FieldNameCollection
    {
        return $this->fieldNameCollection;
    }

    /**
     * Returns all the message list objects as a collection
     */
    public function getMessageLists(): MessageListCollection
    {
        return $this->messageListCollection;
    }

    /**
     * Returns all the combine objects as a collection
     */
    public function getCombines(): CombineCollection
    {
        return $this->combineCollection;
    }

    /**
     * Returns all the custom objects as a collection
     */
    public function getCustoms(): CustomCollection
    {
        return $this->customCollection;
    }

    /**
     * Adds new field validation
     */
    public function field(string ...$fieldNames): FieldOptions
    {
        $fieldOptions = new FieldOptions();

        foreach ($fieldNames as $fieldName) {
            $fieldNameItem = $this->getFieldName($fieldName);
            $fieldNameItem->getFieldOptions()->append($fieldOptions);
        }

        return $fieldOptions;
    }

    /**
     * Adds new error messages
     */
    public function messages(string ...$fieldNames): MessageList
    {
        $messageList = new MessageList();

        // If no field names are provided, save the message list global and not per field name
        if (0 === count($fieldNames)) {
            $this->messageListCollection->append($messageList);
            return $messageList;
        }

        //Save the message list per field name
        foreach ($fieldNames as $fieldName) {
            $fieldNameItem = $this->getFieldName($fieldName);
            $fieldNameItem->getMessageLists()->append($messageList);
        }

        return $messageList;
    }

    /**
     * Adds new middleware
     */
    public function middleware(string ...$fieldNames): MiddlewareList
    {
        $middlewareList = new MiddlewareList();

        //Save the middleware list per field name
        foreach ($fieldNames as $fieldName) {
            $fieldNameItem = $this->getFieldName($fieldName);
            $fieldNameItem->getMiddlewareLists()->append($middlewareList);
        }

        return $middlewareList;
    }

    /**
     * Loads a custom rule based as validation rule. This rule must implements RuleInterface.
     */
    public function loadRule(RuleInterface $rule, string $alias = null): void
    {
        $this->messages()->custom($alias ?? $rule->getName(), $rule->getMessage());

        $this->custom($alias ?? $rule->getName(), function (Current $validator) use ($rule) {
            return $rule->isValid($validator);
        });
    }

    /**
     * Combines multiple fields to one for validation
     */
    public function combine(string ...$fieldNames): Combine
    {
        $combine = new Combine(...$fieldNames);
        $this->combineCollection->append($combine);

        return $combine;
    }

    /**
     * Creates an alias for a provided field name, which can be used to define new rules, middleware, etc.
     */
    public function alias(string $fieldName, string $alias): void
    {
        $this->combine($fieldName)->glue('')->alias($alias);
    }

    /**
     * Loads a custom rule based on a callback function
     */
    public function custom(string $ruleName, Closure $callback): Custom
    {
        $custom = new Custom($ruleName, $callback);
        $this->customCollection->append($custom);

        return $custom;
    }

    private function getFieldName(string $fieldName): FieldName
    {
        $fieldNameItem = $this->fieldNameCollection->get($fieldName);

        if (null === $fieldNameItem) {
            $fieldNameItem = new FieldName($fieldName);
            $this->fieldNameCollection->set($fieldNameItem);
        }

        return $fieldNameItem;
    }
}
