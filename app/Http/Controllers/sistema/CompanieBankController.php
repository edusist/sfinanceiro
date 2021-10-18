<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\CompaniesBank;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanieBankController extends Controller {

    private $obj_Emp_banco;
    private $total_paginas = 8; //Valor para paginação
    protected $data_carbon;

    /*     * ********************************Método Contrutor da classe********************************** */

    public function __construct(CompaniesBank $obModelEmpresa_Banco, Carbon $carbon) {

        $this->obj_Emp_banco = $obModelEmpresa_Banco;
        $this->data_carbon   = $carbon;
        //Autênticação de classe para saber se o usuário e autênticado.
        $this->middleware('auth:admin');
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {

        $objEmpBanco = $this->obj_Emp_banco->paginate($this->total_paginas);
        $title = 'Lista de Contas bancárias';
        
        $data_carbon = $this->data_carbon;
        //Rota do formulário
        return view('empresa_banco.view_empresa_banco', compact('objEmpBanco', 'title', 'data_carbon'));
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {

        $title = 'Cadastrar';
        $objEmpBanco = $this->obj_Emp_banco->paginate($this->total_paginas);

        $obj_banco = DB::table('banks')->get(['id', 'nome']);

        $obj_empresa = DB::table('companies')->get(['id', 'nome']);

        //Rota do formulário
        return view('empresa_banco.create', compact('objEmpBanco', 'title', 'obj_banco', 'obj_empresa'));
    }

    public function store(Request $request) {

        //Pega os dados do formulário
        $dadosForm = $request->all();
        //dd($dadosForm);
        
        //Validação do formulário
        $this->validate($request, $this->obj_Emp_banco->rules);
        
        //Cadastra no Bd
        $cadastrar = $this->obj_Emp_banco->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('empresa_banco_ctrl.index')->with(['sucesso' => 'banco salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($companie_id) {
        
        
        //Busca pelo id_empresa onde seja igual ao parametro id
        $id_banco = $this->obj_Emp_banco
                ->where('companie_id', '=' ,$companie_id)                
                ->get();
        foreach ($id_banco as $id):
            print_r($id->bank_id);
        endforeach;
//        $title = "Alterar Contas bancárias: {$objEmpBanco->nome}";
//
//        //Rota do formulário
//        return view('empresa_banco.create', compact('title', 'objEmpBanco'));
    }

    public function update(Request $request, $id) {

        $this->validate($request, $this->obj_Emp_banco->rules);
        $dadosForm = $request->all();

        $alterar = $this->obj_Emp_banco->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('.index')->with(['success' => 'Contas bancárias Alterado com sucesso!']);

        else:

            return redirect()->back()->with(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objEmpBanco = $this->obj_Emp_empresa_banco->find($id);
        //dd($objEmpBanco);
        $title = "Excluir Banco {$objEmpBanco->nome}";

        //Rota do formulário
        return view('empresa_banco_ctrl.show', compact('title', 'objEmpBanco'));
    }

    public function destroy($id) {

        $deletar = $this->obj_Emp_banco->find($id)->delete();

        if ($deletar):

            return redirect()->route('empresa_banco_ctrl.index')->with(['sucesso' => 'Contas bancárias excluido com sucesso!']);
        else:

            return redirect()->back()->with(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}
