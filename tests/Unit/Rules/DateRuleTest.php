<?php

namespace Tests\Unit\Rules;

use App\Services\Validator\Rules\DateRule;
use Faker\Factory as FakerFactory;
use Carbon\Carbon;

class DateRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa se a data informada é uma data válida
     *
     * @author Carlos Eduardo L. Braz    <carloseduardolbraz@gmail.com>
     * @return void
     */
    public function testValidate()
    {
        $faker    = FakerFactory::create('pt_BR');
        $field    = 'birthday';
        $value    = Carbon::now()->format('d/m/Y');

        $dateRule = new DateRule('');
        $this->assertTrue($dateRule->validate());

        $dateRule = new DateRule($value);
        $this->assertTrue($dateRule->validate());

        $dateRule = new DateRule('45456');
        $this->assertFalse($dateRule->validate());

        $erroValidationMessage = $dateRule->getInvalidatedMessage($field);
        $this->assertEquals($erroValidationMessage, "O campo $field não é um data válida (dd/mm/yyyy)");

    }
}