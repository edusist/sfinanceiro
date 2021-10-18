<?php

namespace App\Http\Controllers\sistema;

use App\Http\Controllers\Controller;
use App\models\Debito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DebitoController extends Controller {

    protected $objDebito;
    protected $objCarbon;
    private $total_paginas = 10; //Valor para paginação

    public function __construct(Debito $debito, Carbon $carbon) {

        $this->objDebito = $debito;
        $this->objCarbon = $carbon;
        $this->middleware('auth:admin');
    }

    public function listaDebitos() {

        $title = 'Débitos da empresa';

        //Somatório dos vréditos
        $total = DB::table('debitos')
                ->select(DB::raw('sum(valor)as total'))
                ->get('valor');

        foreach ($total as $total_cred):

            $somatorio = $total_cred->total;
        endforeach;

        $somatorio = number_format($somatorio, 2, ',', '.');

        //Objeto carbon
        $carbon = $this->objCarbon;

        //$obj_cred = $this->objCred->paginate($this->total_paginas);

        $obj_pag = DB::table('pagamentos')
                ->join('debitos', 'pagamentos.id', '=', 'debitos.pagamento_id')
                ->join('forma_pagamentos', 'debitos.forma_pagamento_id', '=', 'forma_pagamentos.id')                
                ->join('sub_cat_pagamentos', 'pagamentos.subcat_pag_id', '=', 'sub_cat_pagamentos.id')
                ->select('debitos.*', 'pagamentos.nome_pagamento', 'forma_pagamentos.tipo', 'sub_cat_pagamentos.nome')
                ->OrderBy('debitos.data_pagamento', 'desc')
                ->paginate($this->total_paginas);
        
        //dd($obj_pag);

        return view('debitos.lista-debitos', compact('obj_pag', 'title', 'carbon', 'somatorio'));
    }

    public function pago($id) {

        $title = 'Pagar';
        
        //Verifica se existe um pagamento_id salvo na tabela debitos
        $verifica_pago_cad = DB::table('debitos')
                ->where('pagamento_id', '=', $id)
                ->get();

        //Conta a quantidade
        $quant = count($verifica_pago_cad);
        
        //Se retornar 1 já esta cadastrado        
        //Se tiver o receipt_id já cadastrado retorna para index
        if ($quant):

            return redirect()->back()->withErrors(['errors' => 'Já foi pago com id:', $id]);

        else:       

            //recupera uma lista de  pagamentos para exibir na view.
            $recupera_cp = DB::table('pagamentos')
                    ->select('pagamentos.*')
                    ->where('id', '=', $id)
                    ->get();
        
            //Para percorrer toda lista e salvar no array
            foreach ($recupera_cp as $valor):
                $arr_deb = $valor;
            endforeach;

            //Acesso ao objeto de datas
            $dataFormatoBr = $this->objCarbon;

            //Lista das formas de pagamento
            $arr_forma_pagamento = DB::table('forma_pagamentos')
                    ->get(['id', 'tipo']);
            $forma_pagamento = $arr_forma_pagamento;

            //Recupera o nome banco
            $arr_banco = DB::table('banks')
                    ->get(['id', 'nome']);
            foreach ($arr_banco as $banco):
                $nome_banco[] = $banco;
            endforeach;        

            return view('debitos.pago', compact('arr_deb', 'dataFormatoBr', 'title', 'nome_fornecedor', 'forma_pagamento', 'nome_banco'));

        endif;
    }

    //Recuperar dados vindo do formulário pago.blade
    public function postPago(Request $requisicao) {
        
        //dd($requisicao->all());

        //Pega o id-pagamento vindo o formulário campo hidden
        $id_forma_pagamento = $requisicao->input('id-forma-pagamento');
        
        //dd($id_forma_pagamento);
//*************************************Formas de recebimento sem id banco*************************************
        //Verifica qual o forma de pagamento
        if ($id_forma_pagamento == '1' || $id_forma_pagamento == '2' || $id_forma_pagamento == '3' || $id_forma_pagamento == '7'):

            $id_pagamento = $requisicao->input('id-pagamento');

            //Lista pagamento com id
            $pagamento = DB::table('pagamentos')
                            ->where('id', '=', $id_pagamento)
                            ->get(['id', 'nome_pagamento', 'valor', 'data_vencimento']);
            

            //Recupera da tabela pagamentos o id_pagamento, valor, data_vencimento
            foreach ($pagamento as $pag):
                
                $id_pag         = $pag->id;
                $nome_pagamento = $pag->nome_pagamento;
                $valor          = $pag->valor;
                $data_venc      = $pag->data_vencimento;
                
            endforeach;        

            //Lista forma_pagamento com id
            $forma_pagamento = DB::table('forma_pagamentos')
            ->where('id', '=', $id_forma_pagamento)
            ->get(['id']);

            foreach ($forma_pagamento as $forma_pag_id):
                $forma_pagamento_id = $forma_pag_id->id;
            endforeach;
            
            //Converte data padrão EUA
            $data_vencimento_bd = $this->objCarbon->parse($data_venc)->format('Y-m-d H:i:s');
            
            //Recupera a data atual
            $data_atual = $this->objCarbon->now()->format('Y-m-d H:i:s');

            //alterar status de pagamento para 1  
            $alterar = DB::table('pagamentos')
                        ->where('id', $id_pagamento)
                        ->update(['status' => '1']);

            //dd($alterar);
            $salvar_debito = $this->objDebito->create([
                    'valor'              => $valor,
                    'nome_debito'        => $nome_pagamento,
                    'data_pagamento'     => $data_atual,
                    'forma_pagamento_id' => $forma_pagamento_id,
                    'pagamento_id'       => $id_pag,
                    'data_vencimento'    => $data_vencimento_bd,
                    'bank_id'            => null,
            ]);
            
            if ($salvar_debito && $alterar):
                
                //Rota do index dentro do controller
                return redirect()->route('pagamento.index')->with(['sucesso' => 'Crédito salvo com sucesso!']); 
            else:
                return redirect()->back()->withErrors(['errors' => 'Näo possivel salvar o crédito!']);

            endif; 
            
        else://Else Verifica qual o forma de pagamento
            //*************************************Forma de pagamento com com id banco*****************************************
            $id_pagamento = $requisicao->input('id-pagamento');
            $id_forma_pagamento = $requisicao->input('id-forma-pagamento');
            $id_banco = $requisicao->input('id-banco');

            //Lista pagamento com id
            $pagamento = DB::table('pagamentos')
                        ->where('id', '=', $id_pagamento)
                        ->get(['id', 'nome_pagamento', 'valor', 'data_vencimento']);

            //Recupera da tabela pagamentos id_pag, nome_pagamento, valor, data_vencimento
            foreach ($pagamento as $pag):
                $id_pag = $pag->id;
                $nome_pagamento = $pag->nome_pagamento;
                $valor = $pag->valor;
                $data_venc = $pag->data_vencimento;
            endforeach;
            
           //dd($data_venc);

            //Lista forma_pagamento com id
            $forma_pagamento = DB::table('forma_pagamentos')
                                ->where('id', '=', $id_forma_pagamento)
                                ->get(['id']);

            //Recupera o id da forma de pagamento
            foreach ($forma_pagamento as $forma_pag_id):
                $forma_pagamento_id = $forma_pag_id->id;
            endforeach;

            //Lista bancos com id
            $banco = DB::table('banks')
                        ->where('id', '=', $id_banco)
                        ->get(['id']);
            //dd($banco);

            //Recupera o id do banco
            foreach ($banco as $banco_id):

            $banco_id_deb = $banco_id->id;
            //dd($banco_id);

            endforeach;

            $data_atual = $this->objCarbon->now()->format('Y-m-d H:i:s');

            //alterar status de pagamento para 1  
            $alterar = DB::table('pagamentos')
                        ->where('id', $id_pagamento)
                        ->update(['status' => '1']);
            //dd($alterar);
            //Salvar na tabela debito
            $salvar_debito = $this->objDebito->create([
                'valor' => $valor,
                'nome_debito' => $nome_pagamento,
                'data_pagamento' => $data_atual,
                'forma_pagamento_id' => $forma_pagamento_id,
                'pagamento_id' => $id_pag,                
                'bank_id' => $banco_id_deb,
                'data_venc' => $data_venc,
            ]);


            //Verifica se não teve erro na query do BD
            if ($salvar_debito && $alterar):

                //Rota do index dentro do controller
                return redirect()->route('pagamento.index')->with(['sucesso' => 'Crédito salvo com sucesso!']); 

            else:
                return redirect()->back()->withErrors(['errors' => 'Näo possivel salvar o crédito!']);

            endif;

        endif; // fim do if Verifica qual o forma de pagamento    

}

public function filtroFormaPagamento(request $requisicao) {
    
        //dd($requisicao);

        $forma_pag = $requisicao->only(['forma-pag']);

        foreach ($forma_pag as $valor):

            $forma_pagamento = $valor;

        endforeach;

        //dd($forma_pagamento);
        //Pagamento em dinheiro
        if ($forma_pagamento == '1'):

            $title = 'Débitos em Dinheiro';

            //Somatório dos débitos em dinheiro
            $total = DB::select('SELECT SUM(d.valor) as Total FROM pagamentos p
                                    INNER JOIN debitos d
                                    ON(d.pagamento_id = p.id)
                                    INNER JOIN forma_pagamentos f
                                    ON(f.id = d.forma_pagamento_id)
                                    WHERE f.tipo LIKE "%Dinheiro%"'
                                );
                                foreach ($total as $soma):
                                    
                                    $somatorio = $soma->Total;
                                    
                                endforeach;
            //Objeto carbon
            $carbon = $this->objCarbon;
            //Pagamento em dinheiro
            $retorno_pag = DB::select('SELECT d.id, f.tipo, d.nome_debito, p.valor, d.data_pagamento, scp.nome  FROM pagamentos p
                                                    INNER JOIN debitos d
                                                    ON(d.pagamento_id = p.id)
                                                    INNER JOIN forma_pagamentos f
                                                    ON(f.id = d.forma_pagamento_id)
                                                    INNER JOIN sub_cat_pagamentos scp
                                                    ON(scp.id = p.subcat_pag_id)
                                                    WHERE f.tipo LIKE "%Dinheiro%"'
            );


            return view('debitos.filtro_forma_pagamento', compact('retorno_pag', 'title', 'carbon', 'somatorio'));

        else:
            //Forma de pagamento diferente de dinheiro bancos            
            $title = 'Débitos em Bancos';

            //Somatório dos Pagamento no banco
            $total = DB::select('SELECT SUM(d.valor) as Total FROM pagamentos p
                                    INNER JOIN debitos d
                                    ON(d.pagamento_id = p.id)
                                    INNER JOIN forma_pagamentos f
                                    ON(f.id = d.forma_pagamento_id)
                                    WHERE f.tipo NOT LIKE "%Dinheiro%"
                                ');
                                foreach ($total as $soma):
                                    
                                    $somatorio = $soma->Total;
                                    
                                endforeach;
            //Objeto carbon
            $carbon = $this->objCarbon;
            //Pagamento no banco
            $retorno_pag = DB::select('SELECT d.id, f.tipo, d.nome_debito, p.valor, d.data_pagamento, scp.nome  FROM pagamentos p
                                                    INNER JOIN debitos d
                                                    ON(d.pagamento_id = p.id)
                                                    INNER JOIN forma_pagamentos f
                                                    ON(f.id = d.forma_pagamento_id)
                                                    INNER JOIN sub_cat_pagamentos scp
                                                    ON(scp.id = p.subcat_pag_id)
                                                    WHERE f.tipo NOT LIKE "%Dinheiro%"
                                    ');

            return view('debitos.filtro_forma_pagamento', compact('retorno_pag', 'title', 'carbon', 'somatorio'));           

        endif;
    }


}
