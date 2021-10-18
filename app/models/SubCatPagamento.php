<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class SubCatPagamento extends Model {

    //Utilizado para formulários
    use FormAccessible;

    protected $fillable = [
        'nome',
        'descricao',
        'category_payment_id',
        'created_at',
        'updated_at'
    ];
    //Regras de validação
    public $rules = [
        
        'nome' => 'required',
        'descricao' => 'max:100'
    ];

}
