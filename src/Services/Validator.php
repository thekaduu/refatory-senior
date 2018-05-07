<?php

namespace App\Services;

use App\Services\Validator\RuleStrategy;
use App\Services\Validator\Exceptions\ValidationRuleException;

/**
 * Responsavel executa as regras de validação
 * @author Carlos Eduardo L. Braz <carloseduardolbraz@gmail.com>
 */
class Validator
{
    private $rules = [];
    private $invalidErrors = [];

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Valida o array passado por parametro contra as regras
     * definidas no __construct
     *
     * @param array $parameters
     * @throws ValidationRuleException Caso exista algum erro de validação
     * @return boolean
     */
    public function validate(array $parameters) : bool
    {
        foreach ($parameters as $field => $value) {
            $rules = $this->rules[$field];
            // Contador de erros por campo. Caso já exista um erro nesta campo, não executar as outras validações
            $validationErrosByField= 0;
            if (! empty($rules)) {
                foreach ($rules as $rule) {
                    $result = '';
                    $result = explode(":", $rule);
                    $parameters = [];

                    if (isset($result[1])) {
                        $rule = $result[0];
                        $parameters = explode(",", $result[1]);
                    }
                        $ruleValidator = new RuleStrategy($rule);


                    if (! $ruleValidator->validate($value, $parameters) && $validationErrosByField === 0) {
                        //Adicionando ao array de erros
                        $this->invalidErrors[$field] = $ruleValidator->getInvalidatedMessage($field);
                        $validationErrosByField++;
                    }
                }
            }
        }

        if (! empty($this->invalidErrors)) {
            throw new ValidationRuleException($this->invalidErrors);
        }

        return true;
    }
}
