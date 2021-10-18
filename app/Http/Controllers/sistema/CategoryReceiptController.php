<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\CategoryReceipt;
use Carbon\Carbon;


class CategoryReceiptController extends Controller {

    private $objCatReceber;
    private $total_paginas = 8; //Valor para paginação
    protected $data_carbon;

    /*     * ********************************Método Contrutor da classe********************************** */

    public function __construct(CategoryReceipt $obModelCategoryReceipt, Carbon $carbon) {

        $this->objCatReceber = $obModelCategoryReceipt;
        //Autênticação de classe para saber se o categoria e autênticado.
        $this->middleware('auth:admin');
        $this->data_carbon = $carbon;
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {

        $objCatReceber = $this->objCatReceber->paginate($this->total_paginas);
        
        $carbon = $this->data_carbon;
        
        //Testa se o array está vazio
        if (empty($objCatReceber)):

            $title = 'Categoria Recebimento';
            return view('paginaArrayVazio', compact('title'));

        else:

            $title = 'Lista de Categorias Recebimento';            
            //Rota do formulário
            return view('categoriaReceber.catreceberview', compact('objCatReceber', 'title', 'carbon'));

        endif;
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {
        
        $objCatReceber = $this->objCatReceber->paginate($this->total_paginas);
        
        $title = 'Cadastrar';

        //Rota do formulário
        return view('categoriaReceber.formCadastro', compact('objCatReceber', 'title'));
    }

    public function store(Request $request) {

        $dadosForm = $request->all();

        $this->validate($request, $this->objCatReceber->rules);
      

        $cadastrar = $this->objCatReceber->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('categoria_recebimento.index')->with(['sucesso' => 'Categoria salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {
        
        
        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objCatReceber = $this->objCatReceber->find($id);
        
        //dd($objCatReceber);
        $title = "Alterar";

        //Rota do formulário
        return view('categoriaReceber.formCadastro', compact('title', 'objCatReceber'));
    }

    public function update(Request $request, $id) {

        //$this->validate($request, $this->objCatReceber->Rules);
        $dadosForm = $request->all();
        //dd($dadosForm);
        $alterar = $this->objCatReceber->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('categoria_recebimento.index')->with(['sucesso' => 'Categoria Recebimento Alterado com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objCatReceber = $this->objCatReceber->find($id);
        
        $carbon = $this->data_carbon;
        
        $title = "Excluir Categoria Recebimento {$objCatReceber->nome_cat_rec}";
         
        return view('categoriaReceber.show', compact('title', 'objCatReceber', 'carbon'));
    }

    public function destroy($id) {

        $deletar = $this->objCatReceber->find($id)->delete();

        if ($deletar):
            
            return redirect()->route('categoria_recebimento.index')->with(['sucesso' => 'Categoria Recebimento excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}
