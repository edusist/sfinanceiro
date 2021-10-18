<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class Bank extends Model {

    use FormAccessible;

    protected $fillable = ['nome', 'codigo_banco', 'descricao'];
    //Regras de validação
    public $rules = [

        'nome'         => 'required|max:30',
        'codigo_banco' => 'required|max:10',   
        'descricao'    => 'max:100'
    ];

}
