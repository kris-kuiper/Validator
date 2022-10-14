<?php

declare(strict_types=1);

namespace KrisKuiper\Validator;

use JsonException;
use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Collections\RuleCollection;
use KrisKuiper\Validator\Blueprint\Rules\AbstractRule;
use KrisKuiper\Validator\Blueprint\Traits\RuleTrait;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Translator\PathTranslator;

class FieldFilter
{
    use RuleTrait;

    public const FILTER_MODE_PASSED = 1;
    public const FILTER_MODE_FAILED = 0;

    private RuleCollection $ruleCollection;

    /**
     * Constructor
     */
    public function __construct(private PathTranslator $validationData, private string|float|int $fieldName, private int $filterMode = self::FILTER_MODE_PASSED)
    {
        $this->ruleCollection = new RuleCollection();
    }

    /**
     * Filters all the valid or invalid values and converts these into a JSON string
     * @throws ValidatorException|JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    /**
     * Filters all the valid or invalid values and converts these into an array
     * @throws ValidatorException
     */
    public function toArray(): array
    {
        $output = [];

        $paths = $this->validationData->path($this->fieldName);
        $blueprint = new Blueprint();
        $field = $blueprint->field('field');

        foreach ($this->ruleCollection as $rule) {
            $field->{$rule->getName()}(...$rule->getParameters());
        }

        foreach ($paths as $path) {
            $value = $path->getValue();
            $validator = new Validator(['field' => $value]);
            $validator->loadBlueprint($blueprint);

            if (self::FILTER_MODE_PASSED === $this->filterMode && true === $validator->passes()) {
                $output[] = $value;
                continue;
            }

            if (self::FILTER_MODE_FAILED === $this->filterMode && true === $validator->fails()) {
                $output[] = $value;
            }
        }

        return $output;
    }

    /**
     * Adds a new rule to the collection
     */
    private function addRule(AbstractRule $rule): self
    {
        $this->ruleCollection->append($rule);
        return $this;
    }
}
