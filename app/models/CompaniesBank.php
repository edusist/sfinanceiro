<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class CompaniesBank extends Model {

    use FormAccessible;

    protected $fillable = ['agencia', 'conta_corrente', 'operacao', 'digito', 'saldo', 'descricao', 'bank_id', 'companie_id'];
    //Regras de validação
    public $rules = [

        'agencia' => 'required|max:10',
        'conta_corrente' => 'required|max:10',
        'saldo' => 'required',
        'bank_id' => 'required', //Somente teste. maximo deve ser max:8
        'companie_id' => 'required',
    ];

}
