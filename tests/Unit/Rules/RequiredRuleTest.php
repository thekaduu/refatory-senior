<?php

namespace Tests\Unit\Rules;

use App\Services\Validator\Rules\RequiredRule;

class RequiredRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa se um valor passado como '' é vazio e se testa sua mensagem de retorno
     *
     * @author Carlos Eduardo L. Braz    <carloseduardolbraz@gmail.com>
     * @return void
     */
    public function testValidate()
    {
        $field        = 'teste';
        $value        = '';
        $requiredRule = new RequiredRule($value);
        $this->assertFalse($requiredRule->validate());

        $erroValidationMessage = $requiredRule->getInvalidatedMessage($field);

        $this->assertEquals($erroValidationMessage, "O campo $field é obrigatório");
    }
}