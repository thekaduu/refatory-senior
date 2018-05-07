<?php

namespace App\Services\Validator\Interfaces;

/**
 * Define o contrato para todas as implementações de Rules
 *
 * @author Carlos Eduardo L. Braz <carloseduardolbraz@gmail.com>
 */
interface RuleInterface
{
    /**
     * Utilizado para validar de fato
     *
     * @return boolean
     */
    public function validate() : bool;

    /**
     * Retorna a mensagem de erro
     *
     * @param string $field
     * @return string
     */
    public function getInvalidatedMessage(string $field) : string;
}
