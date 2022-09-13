<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Combine;

use KrisKuiper\Validator\Blueprint\Combine\Combine;
use KrisKuiper\Validator\Collections\FieldCollection;
use KrisKuiper\Validator\Exceptions\ValidatorException;
use KrisKuiper\Validator\Fields\Field;

class CombineProxy
{
    /**
     * Contains a cached value of the combined fields
     */
    private mixed $value = null;

    /**
     * Constructor
     */
    public function __construct(private Combine $proxy, private FieldCollection $fieldCollection)
    {
    }

    /**
     * Returns the original blueprint combine object
     */
    public function getProxy(): Combine
    {
        return $this->proxy;
    }

    /**
     * Returns the value of the combined fields
     * @throws ValidatorException
     */
    public function getValue(): string|array|null
    {
        //Retrieve from cache for better performance
        if (null !== $this->value) {
            return $this->value;
        }

        //Determine if the value should be created with the glue or format value
        if (null !== $this->proxy->getGlue()) {
            $this->value = $this->getValueFromGlue();
            return $this->value;
        }

        $this->value = $this->getValueFromFormat();
        return $this->value;
    }

    /**
     * Combines the values with the glue and returns the output
     * @throws ValidatorException
     */
    private function getValueFromGlue(): string
    {
        $values = [];

        /** @var Field $field */
        foreach ($this->fieldCollection as $field) {
            $value = $field->getValue();

            if (true === is_string($value) || true === is_numeric($value)) {
                $values[] = $value;
            }
        }

        $glue = $this->proxy->getGlue();

        if (null === $glue) {
            return '';
        }

        return implode($glue, $values);
    }

    /**
     * Combines the values with the format and returns the output
     * @throws ValidatorException
     */
    private function getValueFromFormat(): string
    {
        $format = $this->proxy->getFormat() ?? '';

        /** @var Field $field */
        foreach ($this->fieldCollection as $field) {
            $format = str_replace(':' . $field->getFieldName(), $field->getValue() ?? '', $format, $count);

            if (0 === $count) {
                throw ValidatorException::formatTypeNotFound($field->getFieldName(), $format);
            }
        }

        return $format;
    }
}
