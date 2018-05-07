<?php

namespace App\Services\Validator\Exceptions;

use \LogicException;

/**
 * Representa os erros de validação
 *
 * @author Carlos Eduardo L. Braz   <carloseduardolbraz@gmail.com>
 */
class ValidationRuleException extends LogicException
{
    /**
     * Erros de valicação
     *
     * @var array
     */
    private $validationErros = [];

    /**
     * Construtor da classse. Receber os erros de validação
     *
     * @param array $validationErros
     */
    public function __construct(array $validationErros)
    {
        $this->validationErros = $validationErros;
        $this->message = "Ocorreu alguns erros de validação. Para recupera-los utilize o método getValidationErrors";
    }

    /**
     * Retorna array com os erros na validação
     *
     * @return array
     */
    public function getValidationErrors() : array
    {
        return $this->validationErros;
    }
}
