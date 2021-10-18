<?php

namespace App\Http\Controllers\sistema;

use App\models\Credito;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreditoController extends Controller {

    protected $objCred;
    protected $objCarbon;
    private $total_paginas = 10; //Valor para paginação

    public function __construct(Credito $credito, Carbon $carbon) {

        $this->objCred = $credito;
        $this->objCarbon = $carbon;
        $this->middleware('auth:admin');
    }

    public function listaCreditos() {

        $title = 'Créditos da empresa';

        //Somatório dos vréditos
        $total = DB::table('creditos')
                ->select(DB::raw('sum(valor)as total'))
                ->get('valor');

        foreach ($total as $total_cred):

            $somatorio = $total_cred->total;
        endforeach;

        $somatorio = number_format($somatorio, 2, ',', '.');

        //Objeto carbon
        $carbon = $this->objCarbon;

        //$obj_cred = $this->objCred->paginate($this->total_paginas);

        $obj_cred = DB::table('creditos')
                ->join('receipts', 'receipts.id', '=', 'creditos.receipt_id')
                ->join('sub_cat_recebimentos', 'receipts.subcat_rec_id', '=', 'sub_cat_recebimentos.id')
                ->join('forma_pagamentos', 'creditos.forma_pagamento_id', '=', 'forma_pagamentos.id')
                ->select('creditos.*', 'forma_pagamentos.tipo', 'sub_cat_recebimentos.nome')
                ->paginate($this->total_paginas);


        return view('creditos.lista-creditos', compact('obj_cred', 'title', 'carbon', 'somatorio'));
    }

    public function recebido($id) {

        $title = 'Recebeminto';

        //Verifica se tem algum crédito cadastrado(dado baixa)
        $verifica_recebido_cad = DB::table('creditos')
                ->where('receipt_id', '=', $id)
                ->get();

        $quant = count($verifica_recebido_cad);

        //Se tiver o crédito já cadastrado retorna para index
        if ($quant):

            return redirect()->back()->withErrors(['errors' => 'Este recebimento com id = ' . $id . ' já foi recebido!']);

        else:


            $recupera_cr = DB::table('receipts')
                    ->select('receipts.*')
                    ->where('id', '=', $id)
                    ->get();

            foreach ($recupera_cr as $valor):
                //dd($valor);

                $arr_cred = $valor;

            endforeach;

//Cliente do recebimento
//            $arr_cliente = DB::table('customers')
//                    ->where('id', '=', $cliente_id)
//                    ->get(['nome_cliente']);
//
//            foreach ($arr_cliente as $cliente):
//                $nome_cliente = $cliente->nome_cliente;
//            endforeach;
            //Acesso ao objeto de datas
            $dataFormatoBr = $this->objCarbon;

            //Lista das formas de pagamento
            $arr_forma_pagamento = DB::table('forma_pagamentos')
                    ->get(['id', 'tipo']);
            $forma_pagamento = $arr_forma_pagamento;

            $arr_banco = DB::table('banks')
                    ->get(['id', 'nome']);
            foreach ($arr_banco as $banco):
                $nome_banco[] = $banco;
            endforeach;

            //print_r($nome_banco);

            return view('creditos.recebido', compact('arr_cred', 'dataFormatoBr', 'title', 'forma_pagamento', 'nome_banco'));

        endif;
    }

    public function postRecebido(Request $requisicao) {


        $id_forma_pagamento = $requisicao->input('id-forma-pagamento');

        //dd($id_forma_pagamento);
//*************************************Formas de recebimento sem id banco*************************************
        //Verifica qual o forma de pagamento
        //Forma de pagamento não bancárias
        if ($id_forma_pagamento == '1' || $id_forma_pagamento == '2' || $id_forma_pagamento == '3' || $id_forma_pagamento == '7'):

            $id_recebimento = $requisicao->input('id-recebimento');

            //Lista recebimento com id
            $recebimento = DB::table('receipts')
                    ->where('id', '=', $id_recebimento)
                    ->get(['id', 'nome_recebimento', 'valor', 'data_vencimento']);

            foreach ($recebimento as $rec):
                $id_rec = $rec->id;
                $nome_recebimento = $rec->nome_recebimento;
                $valor = $rec->valor;
                $data_vencimento = $rec->data_vencimento;
            endforeach;

            //Lista forma_pagamento com id
            $forma_pagamento = DB::table('forma_pagamentos')
                    ->where('id', '=', $id_forma_pagamento)
                    ->get(['id']);

            foreach ($forma_pagamento as $forma_pag_id):

                $forma_pagamento_id = $forma_pag_id->id;
            endforeach;
            //Recupera a data atual
            $data_atual = $this->objCarbon->now()->format('Y-m-d H:i:s');

            //alterar status de pagamento para 1  
            $alterar = DB::table('receipts')
                    ->where('id', $id_recebimento)
                    ->update(['status' => '1']);

            //dd($alterar);
            $salvar_credito = $this->objCred->create([
                'valor' => $valor,
                'nome_credito' => $nome_recebimento,
                'data_recebimento' => $data_atual,
                'forma_pagamento_id' => $forma_pagamento_id,
                'receipt_id' => $id_rec,
                'data_vencimento' => $data_vencimento,
                'bank_id' => null,
            ]);
            if ($salvar_credito && $alterar):

                //Rota do index dentro do controller
                return redirect()->route('recebimento.index')->with(['sucesso' => 'Crédito salvo com sucesso!']);

            else:
                return redirect()->back()->withErrors(['errors' => 'Näo possivel salvar o crédito!']);

            endif;
        else://Else Verifica qual o forma de pagamento
//*************************************Forma de recebimento com com id banco*****************************************
            $id_recebimento = $requisicao->input('id-recebimento');
            $id_forma_pagamento = $requisicao->input('id-forma-pagamento');
            $id_banco = $requisicao->input('id-banco');

            //Lista recebimento com id
            $recebimento = DB::table('receipts')
                    ->where('id', '=', $id_recebimento)
                    ->get(['id', 'nome_recebimento', 'valor', 'data_vencimento']);


            foreach ($recebimento as $rec):
                $id_rec = $rec->id;
                $nome_recebimento = $rec->nome_recebimento;
                $valor = $rec->valor;
                $data_vencimento = $rec->data_vencimento;
            endforeach;

            //Lista forma_pagamento com id
            $forma_pagamento = DB::table('forma_pagamentos')
                    ->where('id', '=', $id_forma_pagamento)
                    ->get(['id']);

            foreach ($forma_pagamento as $forma_pag_id):

                $forma_pagamento_id = $forma_pag_id->id;
            endforeach;

            //Lista bancos com id
            $banco = DB::table('banks')
                    ->where('id', '=', $id_banco)
                    ->get(['id']);
            //dd($banco);

            foreach ($banco as $banco_id):

                $banco_id_cred = $banco_id->id;

            endforeach;

            $data_atual = $this->objCarbon->now()->format('Y-m-d H:i:s');

            //alterar status de pagamento para 1  
            $alterar = DB::table('receipts')
                    ->where('id', $id_recebimento)
                    ->update(['status' => '1']);
            //dd($alterar);
            //Salvar na tabela credito
            $salvar_credito = $this->objCred->create([
                'valor' => $valor,
                'nome_credito' => $nome_recebimento,
                'data_recebimento' => $data_atual,
                'forma_pagamento_id' => $forma_pagamento_id,
                'receipt_id' => $id_rec,
                'data_vencimento' => $data_vencimento,
                'bank_id' => $banco_id_cred,
            ]);


            if ($salvar_credito && $alterar):

                //Rota do index dentro do controller
                return redirect()->route('recebimento.index')->with(['sucesso' => 'Crédito salvo com sucesso!']);

            else:
                return redirect()->back()->withErrors(['errors' => 'Näo possivel salvar o crédito!']);

            endif;

        endif; // fim do if Verifica qual o forma de pagamento
    }

    public function filtroFormaRecebimento(request $requisicao) {

        $forma_pag = $requisicao->only(['forma-pag']);

        foreach ($forma_pag as $valor):

            $forma_pagamento = $valor;

        endforeach;

        //dd($forma_pagamento);
        //Pagamento em dinheiro
        if ($forma_pagamento == '1'):

            $title = 'Créditos em Dinheiro';

            //Somatório dos vréditos
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
            //Objeto carbon
            $carbon = $this->objCarbon;

            $retorno_pag = DB::select('SELECT c.id, f.tipo, c.nome_credito, c.valor, c.data_recebimento, scr.nome FROM receipts r
                                        INNER JOIN creditos c
                                        ON (c.receipt_id = r.id)
                                        INNER JOIN forma_pagamentos f 
                                        ON(c.forma_pagamento_id = f.id)
                                        INNER JOIN sub_cat_recebimentos scr
                                        ON(scr.id = r.subcat_rec_id)
                                        WHERE f.tipo LIKE "%Dinheiro%"'
            );


            return view('creditos.filtro_forma_recebimento', compact('retorno_pag', 'title', 'carbon', 'somatorio'));

        else:
            //Forma de pagamento diferente de dinheiro bancos
            
            $title = 'Créditos em Bancos';

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
            //Objeto carbon
            $carbon = $this->objCarbon;

            $retorno_pag = DB::select('SELECT c.id, f.tipo, c.nome_credito, c.valor, c.data_recebimento, scr.nome FROM receipts r
                                        INNER JOIN creditos c
                                        ON (c.receipt_id = r.id)
                                        INNER JOIN forma_pagamentos f 
                                        ON(c.forma_pagamento_id = f.id)
                                        INNER JOIN sub_cat_recebimentos scr
                                        ON(scr.id = r.subcat_rec_id)
                                        WHERE f.tipo NOT LIKE "%Dinheiro%"
                                    ');

            return view('creditos.filtro_forma_recebimento', compact('retorno_pag', 'title', 'carbon', 'somatorio'));           

        endif;
    }

}

//        echo "<pre>";
//        print_r($obj);        
//        echo "</pre>";
//        echo "<br />";
