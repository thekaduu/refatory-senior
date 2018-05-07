<?php

namespace App\services\Validator\Rules;

use App\Services\Validator\Interfaces\RuleInterface;

/**
 * Representa a regra de validação de um campo obrigatório
 *
 * @author Carlos Eduardo L. Braz    <carlosedaurdolbraz@gmail.com>
 */
final class RequiredRule implements RuleInterface
{
    /**
     * Valor a ser validado
     *
     * @var mixed
     */
    private $value;

    /**
     * Mensagem de erro ao validar
     *
     * @var string
     */
    private $invalidatedMessage = '';

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Verifica se o valor passado no construtor foi passado (não é vazio)
     *
     * @return boolean
     */
    public function validate() : bool
    {
        if (empty($this->value)) {
            $this->invalidatedMessage = 'O campo %s é obrigatório';
            return false;
        }
        return true;
    }

    /**
     * Retorna a mensagem de erro com o nome do campo
     *
     * @param string $field
     * @return string
     */
    public function getInvalidatedMessage(string $field) : string
    {
        return sprintf($this->invalidatedMessage, $field);
    }
}