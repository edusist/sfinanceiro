<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\models\Receipt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class receiptsController extends Controller {

    private $objRec;
    protected $obj_moeda;
    protected $soma = 0;
    private $total_paginas = 6; //Valor para paginação

    public function __construct(Receipt $objRecebimento) {

        $this->objRec = $objRecebimento;
        //Autênticação de classe para saber se o usuário e autênticado.
        $this->middleware('auth:admin');
    }

    public function index() {

        $title = 'Lista de Contas à Receber';

        //inner join em 4 tabelas companies, receipts, customers, category_receipts
        $obj_Rec_tab = DB::table('companies')
                ->join('receipts', 'companies.id', '=', 'receipts.companie_id')
                ->join('customers', 'receipts.customer_id', '=', 'customers.id')
                ->join('category_receipts', 'receipts.category_receipt_id', '=', 'category_receipts.id')
                ->select('receipts.*', 'customers.nome_cliente', 'companies.nome_empresa', 'category_receipts.nome_cat_rec')
                ->OrderBy('receipts.data_vencimento', 'desc')
                ->paginate($this->total_paginas);
        //Chama a função para somar todos os valores de recebimentos 
        $soma = $this->somaRecebimentos();
        //Converte para Moeda Real -Br
        $soma_moeda_real = $this->MoedaReal($soma);

        //Converte data para formato Brasileiro
        $objDataBr = $this->objRec;

        return(view('recebimentos.view_contaReceber', compact('obj_Rec_tab', 'title', 'objDataBr', 'soma_moeda_real')));

        //return view('recebimentos.recebimento');
    }

    //Relatorio pdf
    public function pdf(PDF $pdf) {

        $receber = $this->objRec->all();
        $pdfcliente = $pdf->loadView('recebimentos/receber_pdf', ['receber' => $receber])
                ->setPaper('a4', 'landscape')
                ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        //dd($pdfcliente);
        return $pdfcliente->download('relatorio_recebimentos.pdf');
    }

    //Retorna a pesquisa 
    public function informacaoPesquisa(Request $requisicao) {

        //Receber o valor da pesquisa 
        $receber = $this->listaPesquisa($requisicao['pesquisar']);

        //verifica se achou a alguma pesquisa
        if (count($receber) > 0):

            $pesquisa_rec = array('pesquisar' => $requisicao['pesquisar']);

            $visao = view('recebimentos.lista-pesquisa', compact('receber', 'pesquisa_rec'));

            return response($visao);

        else: return redirect()->back()->withErrors(['errors' => 'Pesquisa não encontrada!']);
        endif;
    }

    public function listaPesquisa($pesquisar) {

        //inner join em 4 tabelas companies, receipts, customers, category_receipts
        return $obj_Rec_tab = DB::table('companies')
                ->join('receipts', 'companies.id', '=', 'receipts.companie_id')
                ->join('customers', 'receipts.customer_id', '=', 'customers.id')
                ->join('category_receipts', 'receipts.category_receipt_id', '=', 'category_receipts.id')
                ->select('receipts.*', 'customers.nome_cliente', 'companies.nome_empresa', 'category_receipts.nome_cat_rec')
                ->where('receipts.nome_recebimento', 'LIKE', '%' . $pesquisar . '%')
                ->orWhere('receipts.nota_fiscal_cr', 'LIKE', '%' . $pesquisar . '%')
                ->orWhere('receipts.valor', 'LIKE', '%' . $pesquisar . '%')
                ->orWhere('receipts.data_vencimento', 'LIKE', '%' . $pesquisar . '%')
                ->OrderBy('receipts.data_vencimento', 'desc')
                ->simplePaginate(30);
    }

    /*     * **************************Métodos para Cadastrar********************************** */

    public function create() {


        $obj_rec = $this->objRec->paginate($this->total_paginas);
        $title = 'Cadastrar novo Recebimento';

        //Instância da classe Empresas
        $obj_empresa = DB::table('companies')->get(['id', 'nome_empresa']);

        //Instância da classe Clientes
        $obj_cliente = DB::table('customers')->get(['id', 'nome_cliente']);

        //Instância da classe Categoria de recebimentos
        $obj_cat_rec = DB::table('category_receipts')->get(['id', 'nome_cat_rec']);

        //Rota do formulário
        return view('recebimentos.formCadastro', compact('obj_rec', 'obj_empresa', 'obj_cliente', 'obj_cat_rec', 'title'));
    }

    public function store(Request $request) {

        $dadosForm = $request->all();
        //dd($dadosForm);
        $this->validate($request, $this->objRec->rules);

        $cadastrar = $this->objRec->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('recebimento.index')->with(['sucesso' => 'Usuário salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * *******************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $obj_rec = $this->objRec->find($id);
        //dd($obj_rec);
        $title = "Alterar  Recebimento: {$obj_rec->nome_recebimento}";

        //Instância da classe Empresas
        $obj_empresa = DB::table('companies')->get(['id', 'nome_empresa']);

        //Instância da classe Clientes
        $obj_cliente = DB::table('customers')->get(['id', 'nome_cliente']);

        //Instância da classe Categoria de recebimentos
        $obj_cat_rec = DB::table('category_receipts')->get(['id', 'nome_cat_rec']);

        //Rota do formulário
        return view('recebimentos.formCadastro', compact('title', 'obj_rec', 'obj_empresa', 'obj_cliente', 'obj_cat_rec'));
    }

    public function update(Request $request, $id) {

        $this->validate($request, $this->objRec->rules);
        $dadosForm = $request->all();

        //dd($dadosForm);
        $alterar = $this->objRec->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('recebimento.index')->with(['sucesso' => ' Recebimento alterado com sucesso!']);

        else:

            return redirect()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * *******************************Métodos para Excluir********************************** */

    public function show($id) {

        //Procura pelo id dentro da tabela receips
        $obj_rec = $this->objRec->find($id);
        //dd($obj_rec);

        $title = "Excluir Recebimento {$obj_rec->nome_recebimento}";

        //Rota do formulário


        return view('recebimentos.show', compact('title', 'obj_rec'));
    }

    public function destroy($id) {

        $deletar = $this->objRec->find($id)->delete();

        if ($deletar):

            return redirect()->route('recebimento.index')->with(['sucesso' => 'Recebimento excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

    public function somaRecebimentos() {

        //Recuperando uma lista de valores de coluna
        $valor = $this->objRec->all()->pluck('valor');

        foreach ($valor as $valor_rec):
            $this->soma += floatval($valor_rec);

        endforeach;

        return $this->soma;
    }

    public function MoedaReal($soma) {

        return number_format($soma, 2, ',', '.');
    }

    public function empresaRecebimento($empresa) {
        
        $title = "Empresa: {$empresa}";
        $rec_empresa = DB::table('companies')
                ->join('receipts', 'companies.id', '=', 'receipts.companie_id')
                ->join('customers', 'receipts.customer_id', '=', 'customers.id')
                ->join('category_receipts', 'receipts.category_receipt_id', '=', 'category_receipts.id')
                ->select('receipts.*', 'customers.nome_cliente', 'companies.nome_empresa', 'category_receipts.nome_cat_rec')
                ->where('companies.nome_empresa', 'LIKE', '%' . $empresa . '%')
                ->OrderBy('receipts.data_vencimento', 'desc')
                ->paginate(5);   
        
        return view('recebimentos.empresaRecebimento', compact('rec_empresa', 'title'));
    }

}

//        echo "<pre>";
//        print_r($obj);        
//        echo "</pre>";
//        echo "<br />";