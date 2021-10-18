<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Provider;

class ProviderController extends Controller
{
     private $obj_fornecedor;
    private $total_paginas = 8; //Valor para paginação

    /*     * ********************************Método Contrutor da classe********************************** */

    public function __construct(Provider $obModelProvider) {

        $this->obj_fornecedor = $obModelProvider;
        //Autênticação de classe para saber se o usuário e autênticado.
        $this->middleware('auth:admin');
    }

    public function pdf(PDF $pdf) {

        $fornecedores = $this->obj_fornecedor->all();         
        $pdffornecedor = $pdf->loadView('pdf', ['fornecedores' => $fornecedores])
                ->setPaper('a4', 'landscape')
                ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                
        //dd($pdffornecedor);
        return $pdffornecedor->download('relatorio_fornecedores.pdf');
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {

        $objFornecedor = $this->obj_fornecedor->paginate($this->total_paginas);

        $title = 'Lista de fornecedores';

        //Rota do formulário
        return view('fornecedores.fornecedores_view', compact('objFornecedor', 'title'));
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {

        $title = 'Cadastrar';
        $objFornecedor = $this->obj_fornecedor->paginate($this->total_paginas);
        //$status = ['1', '2'];
        //Rota do formulário
        return view('fornecedores.create', compact('objFornecedor', 'title'));
    }

    public function store(Request $request) {

        $dadosForm = $request->all();

        $this->validate($request, $this->obj_fornecedor->rules);

        $cadastrar = $this->obj_fornecedor->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('fornecedor.index')->with(['sucesso' => 'Fornecedor salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objFornecedor = $this->obj_fornecedor->find($id);

        $title = "Alterar: {$objFornecedor->nome_fornecedor}";

        //Rota do formulário
        return view('fornecedores.create', compact('title', 'objFornecedor'));
    }

    public function update(Request $request, $id) {

        $this->validate($request, $this->obj_fornecedor->rules);
        $dadosForm = $request->all();

        $alterar = $this->obj_fornecedor->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('fornecedor.index')->with(['sucesso' => 'Fornecedor Alterado com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objFornecedor = $this->obj_fornecedor->find($id);        
        
        $title = "Excluir Fornecedor {$objFornecedor->nome_fornecedor}";

        return view('fornecedores.show', compact('title', 'objFornecedor'));
    }

    public function destroy($id) {

        $deletar = $this->obj_fornecedor->find($id)->delete();

        if ($deletar):

            return redirect()->route('fornecedor.index')->with(['sucesso' => 'Fornecedor excluido com sucesso!!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }
}
