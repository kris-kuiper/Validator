<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint;

use Closure;
use KrisKuiper\Validator\Blueprint\Collections\EventCollection;
use KrisKuiper\Validator\Blueprint\Collections\CombineCollection;
use KrisKuiper\Validator\Blueprint\Collections\CustomCollection;
use KrisKuiper\Validator\Blueprint\Collections\FieldNameCollection;
use KrisKuiper\Validator\Blueprint\Collections\MessageListCollection;
use KrisKuiper\Validator\Blueprint\Combine\Combine;
use KrisKuiper\Validator\Blueprint\Contracts\AfterEventInterface;
use KrisKuiper\Validator\Blueprint\Contracts\BeforeEventInterface;
use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Events\Event;
use KrisKuiper\Validator\Blueprint\Custom\Custom;
use KrisKuiper\Validator\Blueprint\Events\AfterEvent;
use KrisKuiper\Validator\Blueprint\Events\BeforeEvent;
use KrisKuiper\Validator\Blueprint\ValueObjects\FieldName;

class Blueprint
{
    private MessageListCollection $messageListCollection;
    private FieldNameCollection $fieldNameCollection;
    private CombineCollection $combineCollection;
    private CustomCollection $customCollection;
    private EventCollection $beforeCollection;
    private EventCollection $afterCollection;

    public function __construct()
    {
        $this->fieldNameCollection = new FieldNameCollection();
        $this->messageListCollection = new MessageListCollection();
        $this->combineCollection = new CombineCollection();
        $this->customCollection = new CustomCollection();
        $this->beforeCollection = new EventCollection();
        $this->afterCollection = new EventCollection();
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
     * Returns all the before event handlers as a collection
     */
    public function getBeforeEventHandlers(): EventCollection
    {
        return $this->beforeCollection;
    }

    /**
     * Returns all the after event handlers as a collection
     */
    public function getAfterEventHandlers(): EventCollection
    {
        return $this->afterCollection;
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

        $this->custom($alias ?? $rule->getName(), function (Event $event) use ($rule) {
            return $rule->isValid($event);
        });
    }

    /**
     * Loads a custom before event handler object which will be executed before validation starts
     */
    public function loadBeforeEvent(BeforeEventInterface $eventHandler): void
    {
        $this->before(function (BeforeEvent $beforeEvent) use ($eventHandler) {
            $eventHandler->handle($beforeEvent);
        });
    }

    /**
     * Loads a custom after event handler object which will be executed after validation
     */
    public function loadAfterEvent(AfterEventInterface $eventHandler): void
    {
        $this->after(function (AfterEvent $afterEvent) use ($eventHandler) {
            $eventHandler->handle($afterEvent);
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
     * Adds a new before event handler closure to the collection
     */
    public function before(Closure $callback): void
    {
        $this->beforeCollection->append($callback);
    }

    /**
     * Adds a new after event handler closure to the collection
     */
    public function after(Closure $callback): void
    {
        $this->afterCollection->append($callback);
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
