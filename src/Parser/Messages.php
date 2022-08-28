<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Parser;

use KrisKuiper\Validator\Collections\FieldMessageCollection;
use KrisKuiper\Validator\Collections\RuleMessageCollection;

class Messages
{
    private FieldMessageCollection $fieldMessageCollection;
    private RuleMessageCollection $ruleMessageCollection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fieldMessageCollection = new FieldMessageCollection();
        $this->ruleMessageCollection = new RuleMessageCollection();
    }

    /**
     * Returns all the error messages specific set per rule name and field name as a collection
     */
    public function getFieldCollection(): FieldMessageCollection
    {
        return $this->fieldMessageCollection;
    }

    /**
     * Returns all the error messages specific set for rules as a collection
     */
    public function getRuleCollection(): RuleMessageCollection
    {
        return $this->ruleMessageCollection;
    }
}
