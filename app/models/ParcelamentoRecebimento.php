<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ParcelamentoRecebimento extends Model {

    protected $fillable = ['nome_parcela', 'quant_parcelas', 'codigo_parcela', 'receipt_id'];
    //Regras de validação
//    public $rules = [
//        'nome_recebimento' => 'required',        
//        'valor' => 'required',
//        'descricao' => 'max:100',
//        'data_vencimento' => 'required', 
//        'nome_parcela' => 'required', 
//        'quant_parcelas' => 'required',
//        'codigo_parcela' => 'required',       
//        'subcat_pag_id' => 'required'
//    ];

}
