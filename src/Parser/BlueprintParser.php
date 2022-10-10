<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Parser;

use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Collections\DefaultValueCollection;
use KrisKuiper\Validator\Blueprint\Collections\EventCollection;
use KrisKuiper\Validator\Blueprint\FieldOptions;
use KrisKuiper\Validator\Blueprint\Middleware\Middleware;
use KrisKuiper\Validator\Blueprint\MiddlewareList;
use KrisKuiper\Validator\Blueprint\ValueObjects\FieldName;
use KrisKuiper\Validator\Collections\BlueprintCollection;
use KrisKuiper\Validator\Collections\CombineProxyCollection;
use KrisKuiper\Validator\Collections\CustomCollection;
use KrisKuiper\Validator\Collections\FieldCollection;
use KrisKuiper\Validator\Combine\CombineProxy;
use KrisKuiper\Validator\Fields\Field;
use KrisKuiper\Validator\Middleware\MiddlewareProxy;
use KrisKuiper\Validator\Translator\Path;
use KrisKuiper\Validator\Translator\PathTranslator;

class BlueprintParser
{
    private DefaultValueCollection $defaultValueCollection;
    private BlueprintCollection $blueprintCollection;
    private FieldCollection $fieldCollection;
    private CombineProxyCollection $combineProxyCollection;
    private Messages $messages;
    private CustomCollection $customCollection;
    private EventCollection $beforeEventCollection;
    private EventCollection $afterEventCollection;
    private bool $isPopulated = false;

    /**
     * Constructor
     */
    public function __construct(private PathTranslator $validationData)
    {
        $this->defaultValueCollection = new DefaultValueCollection();
        $this->combineProxyCollection = new CombineProxyCollection();
        $this->blueprintCollection = new BlueprintCollection();
        $this->customCollection = new CustomCollection();
        $this->beforeEventCollection = new EventCollection();
        $this->afterEventCollection = new EventCollection();
        $this->fieldCollection = new FieldCollection();
        $this->messages = new Messages();
    }

    public function populate(): void
    {
        if (true === $this->isPopulated) {
            return;
        }

        foreach ($this->getBlueprintCollection() as $blueprint) {
            foreach ($blueprint->getFieldNames() as $fieldName) {
                $this->createFieldsFromFieldName($fieldName);
            }

            foreach ($blueprint->getBeforeEventHandlers() as $beforeEventHandler) {
                $this->beforeEventCollection->append($beforeEventHandler);
            }

            foreach ($blueprint->getAfterEventHandlers() as $afterEventHandler) {
                $this->afterEventCollection->append($afterEventHandler);
            }
        }

        $this->isPopulated = true;
    }

    /**
     * Returns the blueprint collection with all the blueprints that should be used during validation
     */
    public function getBlueprintCollection(): BlueprintCollection
    {
        return $this->blueprintCollection;
    }

    /**
     * Returns the before event handler collection
     */
    public function getBeforeEventCollection(): EventCollection
    {
        return $this->beforeEventCollection;
    }

    /**
     * Returns the after event handler collection
     */
    public function getAfterEventCollection(): EventCollection
    {
        return $this->afterEventCollection;
    }

    /**
     * Returns all the default values as one collection
     */
    public function getDefaultValueCollection(): DefaultValueCollection
    {
        foreach ($this->getBlueprintCollection() as $blueprint) {
            foreach ($blueprint->getDefaultValues() as $defaultValue) {
                $this->defaultValueCollection->append($defaultValue);
            }
        }

        return $this->defaultValueCollection;
    }

    /**
     * Returns the custom (user defined) validator callback collection from all the blueprints combined
     */
    public function getCustomCollection(): CustomCollection
    {
        if ($this->customCollection->count() > 0) {
            return $this->customCollection;
        }

        /** @var Blueprint $blueprint */
        foreach ($this->blueprintCollection->reverse() as $blueprint) {
            foreach ($blueprint->getCustoms() as $custom) {
                if (null !== $custom) {
                    $this->customCollection->append($custom);
                }
            }
        }

        return $this->customCollection;
    }

    /**
     * Returns the combine fields collection from all the blueprints combined
     */
    public function getCombineProxyCollection(): CombineProxyCollection
    {
        if ($this->combineProxyCollection->count() > 0) {
            return $this->combineProxyCollection;
        }

        $combines = [];

        /** @var Blueprint $blueprint */
        foreach ($this->blueprintCollection->reverse() as $blueprint) {
            foreach ($blueprint->getCombines() as $combine) {
                if (null !== $combine) {
                    $alias = $combine->getAlias();

                    if (null === $alias) {
                        continue;
                    }

                    if (true === isset($combines[$alias])) {
                        continue;
                    }

                    $combines[$alias] = $combine;
                    $fieldCollection = new FieldCollection();

                    foreach ($combine->getFieldNames() as $fieldName) {
                        $fieldCollection->append(...$this->createFieldsFromFieldName(new FieldName($fieldName)));
                    }

                    $this->combineProxyCollection->append(new CombineProxy($combine, $fieldCollection));
                }
            }
        }

        return $this->combineProxyCollection;
    }

    /**
     * Returns the custom (user defined) error messages for rules and fields from all the blueprints combined
     */
    public function getMessageCollection(): Messages
    {
        /** @var Blueprint $blueprint */
        foreach ($this->blueprintCollection->reverse() as $blueprint) {
            foreach ($blueprint->getFieldNames() as $fieldName) {
                if (null !== $fieldName) {
                    foreach ($fieldName->getMessageLists() as $messageList) {
                        if (null !== $messageList) {
                            foreach ($messageList->getMessageCollection() as $message) {
                                if (null !== $message) {
                                    $this->messages->getFieldCollection()->append(new Message($message, $fieldName->getFieldName()));
                                }
                            }
                        }
                    }
                }
            }

            foreach ($blueprint->getMessageLists() as $messageList) {
                if (null !== $messageList) {
                    foreach ($messageList->getMessageCollection() as $message) {
                        if (null !== $message) {
                            $this->messages->getRuleCollection()->append(new Message($message));
                        }
                    }
                }
            }
        }

        return $this->messages;
    }

    /**
     * Converts all the field names to field objects from all the blueprints and returns these as a single collection
     */
    public function getFieldCollection(): FieldCollection
    {
        return $this->fieldCollection;
    }

    /**
     * Creates field object(s) from a single field name object, insert unique fields in the field collection and all the found fields as an array
     */
    private function createFieldsFromFieldName(FieldName $fieldName): array
    {
        $name = $fieldName->getFieldName();
        $paths = $this->validationData->path($name);
        $fields = [];

        //If field could not be found within the validation data, create a blank field
        if (0 === $paths->count()) {
            $field = new Field(new Path([]), $name, $this->combineProxyCollection);
            $fields[] = $field;
            $this->fieldCollection->append($field);
        }

        foreach ($paths as $path) {
            if (null !== $path) {
                $field = $this->fieldCollection->getByPath($path);

                if (null === $field) {
                    $field = new Field($path, $name, $this->combineProxyCollection);
                    $this->fieldCollection->append($field);
                }

                $fields[] = $field;
            }
        }

        foreach ($fields as $field) {
            //Append the middleware to the field
            $fieldName->getMiddlewareLists()->each(function (MiddlewareList $middlewareList) use ($field) {
                $middlewareList->getMiddlewareCollection()->each(function (Middleware $middleware) use ($field) {
                    $field->getMiddleware()->append(new MiddlewareProxy($middleware));
                });
            });

            $fieldName->getFieldOptions()->each(function (FieldOptions $fieldOptions) use ($field) {

                $field->getFieldOptions()->append($fieldOptions);
                $bail = $fieldOptions->getBail();

                if (null !== $bail) {
                    $field->setShouldBail($bail);
                }
            });
        }

        return $fields;
    }
}
