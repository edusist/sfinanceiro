<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;

class Pagamento extends Model {

    use FormAccessible;

    protected $fillable = [
        'nome_pagamento',
        'nota_fiscal_cp',
        'valor',
        'status',
        'descricao',
        'data_vencimento',
        'companie_id',
        'subcat_pag_id',
        'bank_id'
    ];
    //Regras de validação
    public $rules = [
        'nome_pagamento' => 'required',
        'valor' => 'required',
        'descricao' => 'max:500',
        'data_vencimento' => 'required',
        'companie_id',
        'subcat_pag_id' => 'required'
    ];

    //Formato de data padrão Brasileiro
    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    //Formato de data padrão Americano BD
    public function formDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    //Data atual no formato padrão Americano BD
    public function dataAtual() {

        return Carbon::now()->format('Y-m-d');
    }

    //Recupera a data do primeiro dia do mês atual - 01
    public function PrimeiroDia() {

        $mes_atual = Carbon::now()->month; //mês atual
        $ano_atual = Carbon::now()->year; //ano atual

        $data_dia_inicial = $ano_atual . "-" . $mes_atual . "-" . "01" . " " . "23:59:59";

        return $data_dia_inicial;
    }

    //Recupera a data do ultimo dia do mês atual - 31
    public function UltimoDia() {

        $mes_atual = Carbon::now()->month; //mês atual
        $ano_atual = Carbon::now()->year; //ano atual

        $data_dia_final = $ano_atual . "-" . $mes_atual . "-" . "31" . " " . "23:59:59";

        return $data_dia_final;
    }

    public function PrimeiroDiaProxMes() {

        $mes_atual = Carbon::now()->month + 1; //mês atual
        $ano_atual = Carbon::now()->year; //ano atual

        $data_dia_inicial = $ano_atual . "-" . $mes_atual . "-" . "01";
        return $data_dia_inicial;
    }

    public function somaPagamento() {

        //Recuperando uma lista de valores de coluna
        $valor = Pagamento::all()->pluck('valor');
        //$valor = $this->objRec->all()->pluck('valor');
        foreach ($valor as $valor_pagar):
            $this->soma += floatval($valor_pagar);

        endforeach;

        return number_format($this->soma, 2, ',', '.');
    }

    public function ultimosMeses() {

        $add_meses = Carbon::now()->subMonth(1)->format('Y-m-d');

        return $add_meses;
    }

    public function proximoSeisMeses() {

        $add_meses = Carbon::now()->addMonth(6)->format('Y-m-d');

        return $add_meses;
    }

}
