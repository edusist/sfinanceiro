<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\CategoryPayment;
use Carbon\Carbon;

class CategoryPaymentController extends Controller {

    private $objCatPagamento;
    private $total_paginas = 8; //Valor para paginação
    private $data_carbon;

    /*********************************Método Contrutor da classe********************************** */

    public function __construct(CategoryPayment $obModelCategoryPayment, Carbon $carbon) {

        $this->objCatPagamento = $obModelCategoryPayment;
        $this->data_carbon = $carbon;

        //Autênticação de classe para saber se o categoria e autênticado.
        $this->middleware('auth:admin');
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {

        $objCatPagamento = $this->objCatPagamento->paginate($this->total_paginas);
        $data_carbon = $this->data_carbon;
        //dd($objCatPagamento);
        //Testa se o array está vazio
        if (empty($objCatPagamento)):

            $title = 'Nova Categoria Pagamento';
            return redirect()->back();

        else:

            $title = 'Lista de Categoria Pagamento';
            //Rota do formulário
            return view('categoriaPagamento.catpagarview', compact('objCatPagamento', 'title', 'data_carbon'));

        endif;
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {


        $objCatPagamento = $this->objCatPagamento->paginate($this->total_paginas);


        $title = 'Cadastrar';

        //Rota do formulário
        return view('categoriaPagamento.formCadastro', compact('objCatPagamento', 'title'));
    }

    public function store(Request $request) {

        $dadosForm = $request->all();

        $this->validate($request, $this->objCatPagamento->rules);

        $cadastrar = $this->objCatPagamento->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('categoria_pagamento.index')->with(['sucesso' => 'Categoria salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {


        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objCatPagamento = $this->objCatPagamento->find($id);

        //dd($objCatPagamento);
        $title = "Alterar Categoria Pagamento: {$objCatPagamento->nome_cat_pag}";

        //Rota do formulário
        return view('categoriaPagamento.formCadastro', compact('title', 'objCatPagamento'));
    }

    public function update(Request $request, $id) {

        //$this->validate($request, $this->objCatPagamento->Rules);
        $dadosForm = $request->all();
        //dd($dadosForm);
        $alterar = $this->objCatPagamento->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('categoria_pagamento.index')->with(['sucesso' => 'Categoria Pagamento Alterado com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objCatPagamento = $this->objCatPagamento->find($id);

        $title = "Excluir Categoria Pagamento {$objCatPagamento->nome_cat_rec}";

        return view('categoriaPagamento.show', compact('title', 'objCatPagamento'));
    }

    public function destroy($id) {

        $deletar = $this->objCatPagamento->find($id)->delete();

        if ($deletar):

            return redirect()->route('categoria_pagamento.index')->with(['sucesso' => 'Categoria Pagamento excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}
