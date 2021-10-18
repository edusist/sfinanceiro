<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Bank;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BankController extends Controller {

    private $obj_banco;    
    private $total_paginas = 8; //Valor para paginação
    private $data_carbon;

    /*     * ********************************Método Contrutor da classe********************************** */

    public function __construct(Bank $obModelBanco, Carbon $carbon) {

        $this->obj_banco = $obModelBanco;
        $this->data_carbon = $carbon;
        $this->middleware('auth:admin');
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {
        
        $objBanco = $this->obj_banco->paginate($this->total_paginas);
        $title = 'Lista de Bancos';
        
        $data_carbon = $this->data_carbon; 
        //Rota do formulário
        return view('banco.viewBank', compact('objBanco', 'title', 'data_carbon'));
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {

        $title = 'Cadastrar';
        $objBanco = $this->obj_banco->paginate($this->total_paginas);
        
        //Rota do formulário
        return view('banco.create', compact('objBanco', 'title'));
    }

    public function store(Request $request) {

        $dadosForm = $request->all();

        $this->validate($request, $this->obj_banco->rules);

        $cadastrar = $this->obj_banco->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('banco_ctrl.index')->with(['sucesso' => 'Banco salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objBanco = $this->obj_banco->find($id);
        
        $title = "Alterar Banco: {$objBanco->nome}";

        //Rota do formulário
        return view('banco.create', compact('title', 'objBanco'));
    }

    public function update(Request $request, $id) {

        $this->validate($request, $this->obj_banco->rules);
        $dadosForm = $request->all();

        $alterar = $this->obj_banco->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('banco_ctrl.index')->with(['sucesso' => 'Banco Alterado com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objBanco = $this->obj_banco->find($id);
        //dd($objBanco);
        $title = "Excluir Banco {$objBanco->nome}";

        return view('banco.show', compact('title', 'objBanco'));
    }

    public function destroy($id) {

        $deletar = $this->obj_banco->find($id)->delete();

        if ($deletar):            
            return redirect()->route('banco_ctrl.index')->with(['sucesso' => 'Banco excluido com sucesso!']);
            
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}
