<?php

namespace Tests\Unit\Rules;

use App\Services\Validator\Rules\CpfRule;
use Faker\Factory as FakerFactory;

class CpfRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa se o cpf é valido e sua mensagem de erro
     *
     * @author Carlos Eduardo L. Braz    <carloseduardolbraz@gmail.com>
     * @return void
     */
    public function testValidate()
    {
        $faker   = FakerFactory::create('pt_BR');
        $field   = 'cpf';
        $value   = $faker->cpf(false);
        $cpfRule = new CpfRule($value);
        $this->assertTrue($cpfRule->validate());

        $cpfRule = new CpfRule('45456');
        $this->assertFalse($cpfRule->validate());

        $erroValidationMessage = $cpfRule->getInvalidatedMessage($field);
        $this->assertEquals($erroValidationMessage, "CPF informado inválido");

    }
}