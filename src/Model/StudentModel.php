<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'phone',
        'birthday'
    ];

}
