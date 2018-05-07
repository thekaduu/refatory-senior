<?php

namespace App\Model;

use App\Model\BaseModel;
use Carbon\Carbon;

class StudentModel extends BaseModel
{
    protected $table = 'students';

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'phone',
        'birthday'
    ];

    /**
     * Ao inserir uma data de nascimento (birthday) converte para uma data válida
     *
     * @author Carlos Eduardo Lima Braz   <carloseduardolbraz@gmail.com>
     * @param [type] $date
     * @return void
     */
    public function setBirthdayAttribute($date)
    {
        if ($date) {
            try {
                $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $date)->toDateTimeString();
            } catch (\InvalidArgumentException $exception) {
                //
            }
        }
    }

    /**
     * Retorna o telefone mascarado (Não formata celular)
     *
     * @author Carlos Eduardo Lima Braz   <carloseduardolbraz@gmail.com>
     * @return string
     */
    public function getPhoneMaskedAttribute() : string
    {
        if ($this->phone) {
            $phoneMask   = '(%s) %s-%s';
            $phone       = $this->phone;
            $dd          = substr($phone, 0, 3);
            $firstPhone  = substr($phone, 3, 4);
            $secondPhone = substr($phone, 7, 4);

            return sprintf($phoneMask, $dd, $firstPhone, $secondPhone);
        }
        return '';
    }

    /**
     * Retorna o cpf mascarado
     *
     * @author Carlos Eduardo Lima Braz   <carloseduardolbraz@gmail.com>
     * @return string
     */
    public function getCpfMaskedAttribute() : string
    {
        if ($this->cpf) {
            $phoneMask   = '%s.%s.%s-%s';
            $firstDigit  = substr($this->cpf, 0, 3);
            $secondDigit = substr($this->cpf, 3, 3);
            $thirdDigit  = substr($this->cpf, 6, 3);
            $finalDigit  = substr($this->cpf, 9, 2);

            return sprintf($phoneMask, $firstDigit, $secondDigit, $thirdDigit, $finalDigit);
        }
    }

    /**
     * Retorna a data de nascimento formatada no padrão brasileiro
     *
     * @author Carlos Eduardo Lima Braz   <carloseduardolbraz@gmail.com>
     * @return string
     */
    public function getBirthdayMaskedAttribute() : string
    {
        if ($this->birthday) {
            return Carbon::parse($this->birthday)->format('d/m/Y');
        }
        return '';
    }
}
