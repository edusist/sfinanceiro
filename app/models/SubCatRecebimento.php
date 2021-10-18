<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class SubCatRecebimento extends Model {

    //Utilizado para formulários
    use FormAccessible;

    protected $fillable = [
        'nome',
        'descricao',
        'category_receipt_id',
        'created_at',
        'updated_at'
    ];
    //Regras de validação
    public $rules = [
        'nome' => 'required',
        'descricao' => 'max:100'
    ];

}
