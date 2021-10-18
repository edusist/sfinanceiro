<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;

class CategoryPayment extends Model
{
     use FormAccessible; //Para utilizar o formulário laravel collective
    //lista branca - Quais campos podem ser preenchidos

    protected $fillable = ['nome_cat_pag', 'descricao'];
    
    //Regras de validação
    public $rules = [
        'nome_cat_pag' => 'required',   
        'descricao'    => 'required|max:500' 
    ];

    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:m:s');
    }
}
