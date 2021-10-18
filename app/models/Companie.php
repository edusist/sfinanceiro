<?php

namespace App\models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class Companie extends Model
{
    
    use FormAccessible; //Para utilizar o formulário laravel collective
    //lista branca - Quais campos podem ser preenchidos

    protected $fillable = ['nome_empresa', 'cnpj_cpf', 'email', 'telefone_fixo', 'telefone_celular', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'uf', 'descricao', 'cidade_id', 'created_at', 'updated_at'];
    //Regras de validação
    public $rules = [

        'nome_empresa'      => 'required|max:30',
        'cnpj_cpf'          => 'required|min:11|max:14',
        'email'             => 'required',
        'telefone_fixo'     => 'required',
        'telefone_celular'  => 'required',        
        'endereco'          => 'required',
        'bairro'            => 'required',   
        'numero'            => 'required', 
        'cidade',
        'uf',
       
    ];

    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:m:s');
    }

}
