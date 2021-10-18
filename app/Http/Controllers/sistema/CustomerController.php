<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\models\Customer;
use Barryvdh\DomPDF\PDF;

class CustomerController extends Controller {

    private $obj_cliente;
    private $total_paginas = 8; //Valor para paginação

    /*     * ********************************Método Contrutor da classe********************************** */

    public function __construct(Customer $obModelCustomer) {

        $this->obj_cliente = $obModelCustomer;
        //Autênticação de classe para saber se o usuário e autênticado.
        $this->middleware('auth:admin');
    }

    public function pdf(PDF $pdf) {

        $clientes = $this->obj_cliente->all();         
        $pdfcliente = $pdf->loadView('pdf', ['clientes' => $clientes])
                ->setPaper('a4', 'landscape')
                ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                
        //dd($pdfcliente);
        return $pdfcliente->download('relatorio_clientes.pdf');
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {

//        $objCliente = $this->obj_cliente->get(['updated_at']);
//        
//        $data = $this->obj_cliente->getDateOfBirthAttribute($objCliente);
//        
//        dd($data);
        $objCliente = $this->obj_cliente->paginate($this->total_paginas);

        $title = 'Lista de Clientes';

        //Rota do formulário
        return view('clientes.clientesview', compact('objCliente', 'title'));
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {

        $title = 'Cadastrar';
        $objCliente = $this->obj_cliente->paginate($this->total_paginas);
        //$status = ['1', '2'];
        //Rota do formulário
        return view('clientes.create', compact('objCliente', 'title'));
    }

    public function store(Request $request) {

        $dadosForm = $request->all();

        $this->validate($request, $this->obj_cliente->rules);

        $cadastrar = $this->obj_cliente->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('cliente.index')->with(['sucesso' => 'Usuário salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objCliente = $this->obj_cliente->find($id);

        $title = "Alterar: {$objCliente->nome_cliente}";

        //Rota do formulário
        return view('clientes.create', compact('title', 'objCliente'));
    }

    public function update(Request $request, $id) {

        $this->validate($request, $this->obj_cliente->rules);
        $dadosForm = $request->all();

        $alterar = $this->obj_cliente->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('cliente.index')->with(['sucesso' => 'Cliente Alterado com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objCliente = $this->obj_cliente->find($id);
        
        $title = "Excluir Cliente {$objCliente->nome_cliente}";

        return view('clientes.show', compact('title', 'objCliente'));
    }

    public function destroy($id) {

        $deletar = $this->obj_cliente->find($id)->delete();

        if ($deletar):

            return redirect()->route('cliente.index')->with(['sucesso' => 'Cliente excluido com sucesso!!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}
