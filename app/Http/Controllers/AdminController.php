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
        $rec = DB::select('SELECT SUM(valor) as somatorio FROM receipts WHERE status <> 1 AND(MONTH (data_vencimento) = MONTH (CURDATE())) ');

        foreach ($rec as $areceber):

            $areceber = number_format($areceber->somatorio, 2, ',', '.');

        endforeach;

        return $areceber;
    }

    public function recebido() {

        $total = DB::table('creditos')
                ->select(DB::raw('sum(valor)as total'))
                ->get('valor');

        foreach ($total as $total_cred):

            $somatorio = $total_cred->total;
        endforeach;

        $recebido = number_format($somatorio, 2, ',', '.');

        return $recebido;
    }

    public function aPagar() {

        //Obtem o valor do pagamento para ser subtraido
        $pag = DB::select('SELECT SUM(valor) as Somatorio FROM pagamentos WHERE status <> 1 AND(MONTH (data_vencimento) = MONTH (CURDATE()))');

        foreach ($pag as $valor_pagar):

            $apagar = $valor_pagar->Somatorio;

        endforeach;
        
        $apagar = number_format($apagar, 2, ',', '.');

        return $apagar;
    }

    public function Pago() {

        $debito = DB::table('debitos')
                ->select(DB::raw('sum(valor)as total'))
                ->get('valor');

        foreach ($debito as $total_deb):

            $somatorio = $total_deb->total;
        endforeach;

        $pago = number_format($somatorio, 2, ',', '.');

        return $pago;
    }

    public function recebidoDinheiro() {


        //Somatório dos créditos
        $total = DB::select('SELECT SUM(c.valor) as Total FROM receipts r
                                    INNER JOIN creditos c
                                    ON(c.receipt_id = r.id)
                                    INNER JOIN forma_pagamentos f
                                    ON(f.id = c.forma_pagamento_id)
                                    WHERE f.tipo LIKE "%Dinheiro%"'
        );
        foreach ($total as $soma):

            $somatorio = $soma->Total;

        endforeach;

        return $somatorio;
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

    public function pagoBanco() {

        $retorn_soma = DB::select('SELECT SUM(d.valor) as Total FROM pagamentos p
                                    INNER JOIN debitos d
                                    ON(d.pagamento_id = p.id)
                                    INNER JOIN forma_pagamentos f
                                    ON(f.id = d.forma_pagamento_id)
                                    WHERE f.tipo NOT LIKE "%Dinheiro%"'
        );

        foreach ($retorn_soma as $total):

            $pago_banco = $total->Total;

        endforeach;



        //Converte de string para float $resultado = floatval($resul_rec) - floatval($resul_pago);
        $resultado = floatval($this->recebidoBanco() - floatval($pago_banco));

        $saldo_banco = number_format($resultado, 2, ',', '.');

        return $saldo_banco;
    }

    public function saldo() {

        //Ainda não foi recebido
        $areceber = $this->aReceber();
        //Ainda não foi pago
        $apagar = $this->aPagar();
        //foi recebido
        $recebido = $this->recebido();
        //foi pago
        $pago = $this->Pago();

        $rec = str_replace(".", "", $this->recebido()); // retirar o ponto
        $resul_recebido = str_replace(",", ".", $rec); // substituir ',' por '.'

        $pag = str_replace(".", "", $this->Pago()); // retirar o ponto
        $resul_pago = str_replace(",", ".", $pag); // substituir ',' por '.'
        //Converte de string para float
        $resultado = floatval($resul_recebido) - floatval($resul_pago);
        $saldo = number_format($resultado, 2, ',', '.');

        //$conta_rec = $areceber;

        $valor1 = str_replace(",", "", $areceber);
        $valor1 = str_replace(".", "", $valor1);

        $valor2 = str_replace(",", "", $apagar);
        $valor2 = str_replace(".", "", $valor2);

        //print_r($valor1 . "-" . $valor2);
        $saldo_fluxo = $valor1 - $valor2; 
        
        $obj_moeda_mundial = new MoedaMundialController();
        $retorno_formatoBd = $obj_moeda_mundial->formatoBd($saldo_fluxo);
        //dd($retorno_formatoBd);
        
        $saldo_fluxo = number_format(intval($saldo_fluxo), 2, '.', '');
        
        

        $saldo_dinheiro = $this->pagoDinheiro();

        $saldo_banco = $this->pagoBanco();

        return view('pag-admin-home', compact('areceber', 'apagar', 'recebido', 'pago', 'saldo', 'saldo_dinheiro', 'saldo_banco', 'saldo_fluxo'));
    }

}
