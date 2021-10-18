<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\User;


class UserController extends Controller {

    private $obj_user;
    private $total_paginas = 4; //Valor para paginação

    
    /**********************************Método Contrutor da classe***********************************/
    public function __construct(User $objModelUser) {//Instancia um objeto tipo Model

        $this->obj_user = $objModelUser;
        $this->middleware('auth:admin');
    }
    
    /**********************************Métodos para Listar***********************************/
    public function index() {

        $objUser = $this->obj_user->paginate($this->total_paginas);
        $objData = $this->obj_user;
        $title = 'Lista de Usuários';
        $mensagem = '';

        return view('usuarios.index', compact('objUser', 'objData', 'mensagem', 'title'));
    }

    /**********************************Métodos para Cadastrar***********************************/
    public function create() {

        $title = 'Cadastrar';
        $objUser = $this->obj_user->all();
        
        $objOff = DB::table('officials')->get(['id', 'nome']);        
        //dd($objOff);
        return view('usuarios.create', compact('title', 'objOff', 'objUser'));
    }

  
    public function store(Request $request) {

        //Pega os dados do formulário
        $dadosform = $request->all();

        //Validação do formulário
        $this->validate($request, $this->obj_user->rules);

        //Cadastra no Bd
        $cadastrar = $this->obj_user->create($dadosform);

        if ($cadastrar):
            
            return redirect()->route('usuarios.index')->with(['sucesso' => 'Usuário salvo com sucesso!']);
        else:
            return redirect()->back();

        endif;
    }

    /**********************************Métodos para Editar***********************************/
    public function edit($id) {

        $objUser = $this->obj_user->find($id);
        //dd($objUser->id);
        $objOff = DB::table('officials')->get(['id', 'nome'])->toArray();

        $title = "Alterar usuário: {$objUser->nome}";

        return view('usuarios.create', compact('title', 'objUser', 'objOff'));
    }

    public function update(Request $request, $id) {

        //Validação do formulário
        $this->validate($request, $this->obj_user->rules);

        $dadosForm = $request->all();

        $alterar = $this->obj_user->find($id)->update($dadosForm);

        if ($alterar):
            
//            $mensagem = 'Usuário salvo com sucesso!';
//            $msn = new Response();
             //$msn->header('Content-Type', $mensagem);        
     
    return redirect()->route('usuarios.index')->with(['sucesso' => 'Usuário salvo com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /**********************************Métodos para Excluir***********************************/

        public function show($id) {

        $objUser = $this->obj_user->find($id);
        $title = "Excluir usuário {$objUser->nome}";
        //dd($objUser->id);
        return view('usuarios.show', compact('title', 'objUser'));
    }

        public function destroy($id) {

        $deletar = $this->obj_user->find($id)->delete();

        if ($deletar):

            $mensagem = ' ';
            return redirect()->route('usuarios.index')->with(['sucesso' => 'Usuário excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

      /**********************************Métodos para teste de formulário***********************************/
        public function cadastroform() {

        $title = 'Formulário de exemplo';
        $objOff = DB::table('officials')->get(['nome']);
        //dd($obj_Off);       


        return view('usuarios.cadastroform', compact('title', 'objOff'));
    }

}
