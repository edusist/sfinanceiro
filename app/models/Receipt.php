<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class Receipt extends Model {

    //Utilizado para formulários
    use FormAccessible;

    protected $obj_empresa;
    
    protected $fillable = [
        'nome_recebimento',        
        'valor',
        'status',
        'nota_fiscal_cr',
        'descricao',
        'data_vencimento',
        'companie_id',
        'subcat_rec_id',
        'created_at',
        'updated_at'
    ];
    //Regras de validação
    public $rules = [
        'nome_recebimento' => 'required|max:50',        
        'valor' => 'required',
        'descricao' => 'max:500',
        'data_vencimento' => 'required',
        'subcat_rec_id' => 'required'
    ];

    public function recebeParcelamento() {

        return $this->hasMany(Parcelamento::class);
    }

    //Formato de data padrão Brasileiro
    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    //Formato de data padrão Americano BD
    public function formDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function PrimeiroDiaProxMes() {

        $mes_atual = Carbon::now()->addMonth()->format('Y-m-d'); //mês atual
        //$ano_atual = Carbon::now()->addMonth();

        $data_dia_inicial =$mes_atual;
        
        return $data_dia_inicial;
    }

    public function PrimeiroDia() {

        $mes_atual = Carbon::now()->month; //mês atual
        $ano_atual = Carbon::now()->year; //ano atual

        $data_dia_inicial = $ano_atual . "-" . $mes_atual . "-" . "01"." "."23:59:59";
        return $data_dia_inicial;
    }

    public function dataAtualBd() {

        $data_atual = Carbon::now()->format('Y-m-d');

        return $data_atual;
    }

    public function UltimoDia() {

        $mes_atual = Carbon::now()->month; //mês atual
        $ano_atual = Carbon::now()->year; //ano atual     
         
        //Necessário colocar as horas também para lista das do dia 31
        $data_dia_final = $ano_atual."-".$mes_atual."-"."31"." "."23:59:59";
      
        return $data_dia_final;
    }
    //2 meses anteriores
    public function ultimosMeses() {       
        

        $add_meses = Carbon::now()->subMonth(2)->format('Y-m-d');

        return $add_meses;
    }

    public function proximoSeisMeses() {

        $add_meses = Carbon::now()->addMonth(6)->format('Y-m-d');

        return $add_meses;
    }

}
