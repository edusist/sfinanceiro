<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class Customer extends Model {

    use FormAccessible; //Para utilizar o formulário laravel collective
    //lista branca - Quais campos podem ser preenchidos  
    
    protected $fillable = ['nome_cliente', 'cnpj_cpf', 'email', 'telefone_fixo', 'telefone_celular', 'status', 'endereco', 'cidade', 'estado', 'descricao'];
    //Regras de validação
    public $rules = [
        'nome_cliente' => 'required|max:30',
        'cnpj_cpf' => 'required|min:13|max:13',
        'email' => 'required',
        'telefone_fixo' => 'required',
        'telefone_celular' => 'required',
        'status' => 'required', //Somente teste. maximo deve ser max:8
        'endereco' => 'required',
        'cidade' => 'required',
        'estado' => 'required',
        'descricao'
    ];

    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

}
