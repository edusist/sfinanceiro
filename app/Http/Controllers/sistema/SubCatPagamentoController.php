<?php

namespace App\Http\Controllers\sistema;

use App\models\SubCatPagamento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\models\CategoryPayment;

class SubCatPagamentoController extends Controller {

    protected $objSubCatPag;
    protected $objCarbon;
    protected $total_paginas = 10;

    public function __construct(SubCatPagamento $subCatPag, Carbon $carbon) {

        $this->objSubCatPag = $subCatPag;
        $this->objCarbon = $carbon;
        //Autênticação de classe para saber se o categoria e autênticado.
        $this->middleware('auth:admin');
    }

    public function index() {
        $title = 'Sub-categorias Pagamento';
        $objSubCatPag = DB::table('sub_cat_pagamentos')
                ->join('category_payments', 'category_payments.id', '=', 'sub_cat_pagamentos.category_payment_id')
                ->select('sub_cat_pagamentos.*', 'category_payments.nome_cat_pag')
                ->OrderBy('sub_cat_pagamentos.id')
                ->paginate($this->total_paginas);

        $objCarbon = $this->objCarbon;

        return view('categoriaPagamento.view_sub_cat_pagamento', compact('objSubCatPag', 'objCarbon', 'title'));
    }

    public function create() {

        $title = 'Cadastro';

        //Recupera todas subcategorias
        $objSubCatPag = $this->objSubCatPag->paginate($this->total_paginas);

        //Recupera todas categorias pagamentos para ser lista no select html
        $categoria_pag = CategoryPayment::all(['id', 'nome_cat_pag']);

        //dd($categoria_pag);

        return view('categoriaPagamento.cadastro-sub-cat-pag', compact('objSubCatPag', 'categoria_pag', 'title'));
    }

    public function store(Request $requisicao) {

        //Recebe todos inputs vindos do formulário
        $dadosForm = $requisicao->all();

        //Validação
        $this->validate($requisicao, [
            'nome' => 'required|unique:sub_cat_pagamentos',
            'category_payment_id' => 'required',
            'descricao' => 'max:100'
        ]);


        //Salva dentro do Bd
        $cadastrar = $this->objSubCatPag->create($dadosForm);


        //Direciona o usuário para seguintes telas
        if ($cadastrar):

            return redirect()->route('sub_categoria_pagamento.index')->with(['sucesso' => 'Sub-Categoria salvo com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    public function edit($id) {

        $objSubCatPag = $this->objSubCatPag->find($id);

        $title = "Alterar Sub-Categoria Pagamento: {$objSubCatPag->nome}";

        //Instância da classe Categoria de pagamentos
        $categoria_pag = DB::table('category_payments')->get(['id', 'nome_cat_pag']);

        return view('categoriaPagamento.cadastro-sub-cat-pag', compact('objSubCatPag', 'categoria_pag', 'title'));
    }

    public function update(Request $requisicao, $id) {

        //Recupera o que usuário alterou no formulário
        $nome = $requisicao->input('nome');
        $categoria_pagamento = $requisicao->input('category_payment_id');
        $descricao = $requisicao->input('descricao');

        //Fazer a alteração no BD
        $alterar = $this->objSubCatPag->find($id)->update([
            'nome' => $nome,
            'category_payment_id' => $categoria_pagamento,
            'descricao' => $descricao
        ]);

        if ($alterar):

            return redirect()->route('sub_categoria_pagamento.index')->with(['sucesso' => 'Sub-categoria alterada com sucesso!']);

        else:

            return redirect()->withErrors(['errors' => 'Näo possivel alterar!']);
        endif;
    }

    public function show($id) {

        //Procura pelo id dentro da tabela sub_categoria
        $obj_sub_cat = $this->objSubCatPag->find($id);

        $title = "Excluir sub-categoria {$obj_sub_cat->nome}";

        $data_carbon = $this->objCarbon;

        //Rota do formulário 
        return view('categoriaPagamento.excluir-sub-cat-pag', compact('title', 'obj_sub_cat', 'data_carbon'));
    }

    public function destroy($id) {

        $deletar = $this->objSubCatPag->find($id)->delete();

        if ($deletar):

            return redirect()->route('sub_categoria_pagamento.index')->with(['sucesso' => 'Sub-Categoria Pagamento excluida com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}
