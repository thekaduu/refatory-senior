<?php

namespace App\services\Validator\Rules;

use App\Services\Validator\Interfaces\RuleInterface;

/**
 * Representa a regra de validação para se um valor já
 * foi inserido para uma coluna no banco de dados
 *
 * @author Carlos Eduardo L. Braz  <carlosedaurdolbraz@gmail.com>
 */
final class UniqueRule implements RuleInterface
{
    /**
     * Valor a ser validado
     *
     * @var mixed
     */
    private $value;

    private $invalidatedMessage = '';

    /**
     * Define qual é a model para fazer a consulta e qual o campo
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Construtor da classe
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Verifica se o cpf informado é válido
     *
     * @return boolean
     */
    public function validate() : bool
    {
        if (empty($this->value)) {
            return true;
        }

        if (count($this->parameters) < 2) {
            throw new \InvalidArgumentException;
        }

        list($modelName, $fieldName, $id) = $this->parameters;

        //@todo Isolar esse código para poder ser modular
        $model        = "App\Model\\{$modelName}";
        $queryBuilder = $model::where($fieldName, $this->value);

        if (!empty($id)) {
            $queryBuilder->where("id", '!=', $id);
        }

        $isValid = $queryBuilder->get()->isEmpty();

        if (! $isValid) {
            $this->invalidatedMessage = 'Já existe um %s com este valor';
            return false;
        }
        return true;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
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
