<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class FormaPagamento extends Model {

    //Utilizado para formulários
    use FormAccessible;

    protected $fillable = [
        'tipo'
    ];
    
    //Regras de validação
    public $rules = [
        'tipo' => 'required',
    ];

}
