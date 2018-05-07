<?php

namespace App\services\Validator\Rules;

use App\Services\Validator\Interfaces\RuleInterface;

/**
 * Representa a regra de validação para CPF
 *
 * @author Carlos Eduardo L. Braz  <carlosedaurdolbraz@gmail.com>
 */
final class CpfRule implements RuleInterface
{
    /**
     * Valor a ser validado
     *
     * @var mixed
     */
    private $cpf;

    /**
     * Mensagem de erro ao validar
     *
     * @var string
     */
    private $invalidatedMessage = '';

    public function __construct($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * Verifica se o cpf informado é válido
     *
     * @return boolean
     */
    public function validate() : bool
    {
        if (empty($this->cpf)) {
            return true;
        }

        if (! $this->validaCPF($this->cpf)) {
            $this->invalidatedMessage = 'CPF informado inválido';
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

    /**
     * Valida um CPF
     *
     * @see http://www.geradorcpf.com/script-validar-cpf-php.htm
     * @param string $cpf
     * @return boolean
     */
    public function validaCPF(string $cpf) : bool
    {
        // Verifica se um número foi informado
        if (empty($cpf) || ! is_numeric($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
        } else {
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }
}