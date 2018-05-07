<?php

namespace App\services\Validator\Rules;

use App\Services\Validator\Interfaces\RuleInterface;
use Carbon\Carbon;
use \InvalidArgumentException;

/**
 * Representa a regra de validação para campos do tipo date
 *
 * @author Carlos Eduardo L. Braz  <carlosedaurdolbraz@gmail.com>
 */
final class DateRule implements RuleInterface
{
    /**
     * Valor a ser validado
     *
     * @var string
     */
    private $date;

    /**
     * Mensagem de erro ao validar
     *
     * @var string
     */
    private $invalidatedMessage = '';

    /**
     * Construtor
     *
     * @param string $date
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Verifica se o cpf informado é válido
     *
     * @return boolean
     */
    public function validate() : bool
    {
        if (empty($this->date)) {
            return true;
        }

        try {
            //Apenas pra validar a data
            Carbon::createFromFormat('d/m/Y', $this->date)->toDateTimeString();
            return true;
        } catch (InvalidArgumentException $exception) {
            $this->invalidatedMessage = 'O campo %s não é um data válida (dd/mm/yyyy)';
            return false;
        }
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
