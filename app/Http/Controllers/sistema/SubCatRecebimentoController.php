<?php

namespace App\Http\Controllers\sistema;

use App\models\SubCatRecebimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\models\CategoryReceipt;

class SubCatRecebimentoController extends Controller
{
    
    protected $objSubCatRec;
    protected $objCarbon;
    protected $total_paginas = 10;

    public function __construct(SubCatRecebimento $subCatRec, Carbon $carbon) {

        $this->objSubCatRec = $subCatRec;
        $this->objCarbon = $carbon;
        //Autênticação de classe para saber se o categoria e autênticado.
        $this->middleware('auth:admin');
    }

    public function index() {
        $title = 'Sub-categorias Recebimento';
        $objSubCatRec = DB::table('sub_cat_recebimentos')
                ->join('category_receipts', 'category_receipts.id', '=', 'sub_cat_recebimentos.category_receipt_id')
                ->select('sub_cat_recebimentos.*', 'category_receipts.nome_cat_rec')
                ->take($this->total_paginas)
                ->get();

        $objCarbon = $this->objCarbon;

        return view('categoriaReceber.view_sub_cat_recebimento', compact('objSubCatRec', 'objCarbon', 'title'));
    }

    public function create() {

        $title = 'Cadastro';

        //Recupera todas subcategorias
        $objSubCatRec = $this->objSubCatRec->paginate($this->total_paginas);

        //Recupera todas categorias recebimentos para ser lista no select html
        $categoria_rec = CategoryReceipt::all(['id', 'nome_cat_rec']);
     

        return view('categoriaReceber.cadastro-sub-cat-rec', compact('objSubCatRec', 'categoria_rec', 'title'));
    }

    public function store(Request $requisicao) {

        //Recebe todos inputs vindos do formulário
        $dadosForm = $requisicao->all();

        //Validação
        $this->validate($requisicao, [
            'nome' => 'required|unique:sub_cat_recebimentos',
            'category_receipt_id' => 'required',
            'descricao' => 'max:100'
        ]);


        //Salva dentro do Bd
        $cadastrar = $this->objSubCatRec->create($dadosForm);


        //Direciona o usuário para seguintes telas
        if ($cadastrar):

            return redirect()->route('sub_categoria_recebimento.index')->with(['sucesso' => 'Sub-Categoria salvo com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    public function edit($id) {

        $objSubCatRec = $this->objSubCatRec->find($id);

        $title = "Alterar Sub-Categoria Recebimento: {$objSubCatRec->nome}";

        //Instância da classe Categoria de recebimentos
        $categoria_rec = DB::table('category_receipts')->get(['id', 'nome_cat_rec']);

        return view('categoriaReceber.cadastro-sub-cat-rec', compact('objSubCatRec', 'categoria_rec', 'title'));
    }

    public function update(Request $requisicao, $id) {

        //Recupera o que usuário alterou no formulário
        $nome = $requisicao->input('nome');
        $categoria_recebimento = $requisicao->input('category_receipt_id');
        $descricao = $requisicao->input('descricao');

        //Fazer a alteração no BD
        $alterar = $this->objSubCatRec->find($id)->update([
            'nome' => $nome,
            'category_receipt_id' => $categoria_recebimento,
            'descricao' => $descricao
        ]);

        if ($alterar):

            return redirect()->route('sub_categoria_recebimento.index')->with(['sucesso' => 'Sub-categoria alterada com sucesso!']);

        else:

            return redirect()->withErrors(['errors' => 'Näo possivel alterar!']);
        endif;
    }

    public function show($id) {

        //Procura pelo id dentro da tabela sub_categoria
        $obj_sub_cat = $this->objSubCatRec->find($id);

        $title = "Excluir sub-categoria {$obj_sub_cat->nome}";

        $data_carbon = $this->objCarbon;

        //Rota do formulário 
        return view('categoriaReceber.excluir-sub-cat-rec', compact('title', 'obj_sub_cat', 'data_carbon'));
    }

    public function destroy($id) {

        $deletar = $this->objSubCatRec->find($id)->delete();

        if ($deletar):

            return redirect()->route('sub_categoria_recebimento.index')->with(['sucesso' => 'Sub-Categoria Recebimento excluida com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }
}
