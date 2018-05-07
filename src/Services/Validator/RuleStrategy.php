<?php

namespace App\Services\Validator;

class RuleStrategy
{
    private $strategyName;

    private $rule;


    public function __construct($ruleName)
    {
        $this->strategyName = 'App\Services\Validator\Rules' . '\\' . ucwords($ruleName) . "Rule";
    }

    public function validate($value, array $parameters = []) : bool
    {
        $this->rule = new $this->strategyName($value);

        if (! empty($parameters)) {
            $this->rule->setParameters($parameters);
        }
        return $this->rule->validate();
    }

    public function getInvalidatedMessage(string $field) : string
    {
        return $this->rule->getInvalidatedMessage($field);
    }


}
