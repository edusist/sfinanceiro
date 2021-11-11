<?php

namespace App\Http\Controllers;

use App\Http\Controllers\sistema\receiptsController;
use App\Http\Controllers\sistema\PagamentoController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\sistema\MoedaMundialController;

class AdminController extends Controller {

    protected $obj_rec;
    protected $obj_pag;

    /**
     * Criar uma nova instância do controlador.
     *
     * @return void
     */
    public function __construct(receiptsController $recebimento, PagamentoController $pagamento) {
        $this->middleware('auth:admin');
        $this->obj_rec = $recebimento;
        $this->obj_pag = $pagamento;
    }

    /**
     * Mostrar o painel de administrador.
     *
     * @return \Illuminate\Http\Response
     */
    //Está amarrado ao middleware

    public function index() {
        
    }

    public function aReceber() {

        //Obtem o valor do recebimento para substrair 'receipt')->where('status', '<>', 1);
        $rec = DB::select('SELECT SUM(valor) as somatorio FROM receipts 
                                    WHERE (YEAR(data_vencimento) = YEAR(CURDATE()))
                                    AND(MONTH (data_vencimento) = MONTH (CURDATE()))');

        foreach ($rec as $aReceber):

            $aReceber = $aReceber->somatorio;

        endforeach;

        return $aReceber;
    }

    public function aPagar() {

        //Obtem o valor do pagamento para ser subtraido
        $pag = DB::select('SELECT SUM(valor) as Somatorio FROM pagamentos 
                                WHERE (YEAR(data_vencimento) = YEAR(CURDATE()))
                                AND(MONTH (data_vencimento) = MONTH (CURDATE()))');

        foreach ($pag as $valor_pagar):

            $aPagar = $valor_pagar->Somatorio;

        endforeach;
        
        // $aPagar = number_format($aPagar, 2, ',', '.');

        return $aPagar;
    }


    public function recebido() {

        $total = DB::table('creditos')
                ->select(DB::raw('sum(valor)as total'))
                ->whereRaw('(MONTH(creditos.data_recebimento) = MONTH(CURDATE()))')
                ->whereRaw('(YEAR(creditos.data_recebimento) = YEAR(CURDATE()))')
                ->get('valor');

        foreach ($total as $total_cred):

            $somatorio = $total_cred->total;
        endforeach;

        // $recebido = number_format($somatorio, 2, ',', '.');

        return $somatorio;
    }

    public function Pago() {

        $debito = DB::table('debitos')
                ->select(DB::raw('sum(valor)as total'))
                ->whereRaw('(MONTH(debitos.data_pagamento) = MONTH(CURDATE()))')
                ->whereRaw('(YEAR(debitos.data_pagamento) = YEAR(CURDATE()))')
                ->get('valor');

        foreach ($debito as $total_deb):

            $somatorio = $total_deb->total;
        endforeach;

        // $pago = number_format($somatorio, 2, ',', '.');

        return $somatorio;
    }

  
    public function saldo() {

          //1º parametro substitui na 3º string com 2º parametro  
        //echo str_replace("world","Peter","Hello world!");

        //Ainda não foi recebido
        $aReceber = $this->formatoReal($this->aReceber());

        //Ainda não foi pago
        $aPagar = $this->formatoReal($this->aPagar());

        //foi recebido
        $recebido = $this->formatoReal($this->recebido());

        //foi pago
        $pago = $this->formatoReal($this->Pago());

        

        //************************Saldo = Crédito - Débito********************** */         
        $resul_fluxo = floatval($this->recebido()) - floatval($this->Pago());
        // print_r(floatval($resul_fluxo));
        
        $saldo_fluxo = $this->formatoReal($resul_fluxo);
       

        //************************Saldo_fluxo = ContaReceber -ContaPagar********************** */
        $resultadoCRec_Cpag = floatval($this->aReceber()) - floatval($this->aPagar());        
        $saldo = $this->formatoReal($resultadoCRec_Cpag);       

        

        return view('pag-admin-home', compact('aReceber', 'aPagar', 'recebido', 'pago', 'saldo', 'saldo_fluxo'));//'saldo_dinheiro', 'saldo_banco'
    }

    public function formatoReal($valor) {

        $resultado = number_format($valor, 2, ",", ".");
      
        return $resultado; 
    }

    public function recebidoBanco() {

        //Somatório dos créditos
        $total = DB::select('SELECT SUM(c.valor) as Total FROM receipts r
                                    INNER JOIN creditos c
                                    ON(c.receipt_id = r.id)
                                    INNER JOIN forma_pagamentos f
                                    ON(f.id = c.forma_pagamento_id)
                                    WHERE f.tipo NOT LIKE "%Dinheiro%"
                                ');
        foreach ($total as $soma):

            $somatorio = $soma->Total;

        endforeach;

        return $somatorio;
    }

    public function pagoDinheiro() {

        $retorn_soma = DB::select('SELECT SUM(d.valor) as Total FROM pagamentos p
                                    INNER JOIN debitos d
                                    ON(d.pagamento_id = p.id)
                                    INNER JOIN forma_pagamentos f
                                    ON(f.id = d.forma_pagamento_id)
                                    WHERE f.tipo LIKE "%Dinheiro%"'
        );

        foreach ($retorn_soma as $total):

            $pago = $total->Total;

        endforeach;

        //Converte de string para float $resultado = floatval($resul_rec) - floatval($resul_pago);
        
        
        $resultado = floatval($this->recebidoDinheiro() - floatval($pago));
      

        $saldo_dinheiro = number_format($resultado, 2, ',', '.');

        return $saldo_dinheiro;
    }

}
