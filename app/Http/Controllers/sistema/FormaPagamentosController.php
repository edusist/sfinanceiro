<?php

namespace App\Http\Controllers\sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\models\FormaPagamento;

class FormaPagamentosController extends Controller
{
    protected $obj_forma_paga;
    protected $total_paginas = 10; //Valor para paginação
    protected $data_carbon;
    
    public function __construct(FormaPagamento $forma_pag, Carbon $carbon){
        
        $this->obj_forma_paga = $forma_pag;
        $this->data_carbon    = $carbon;
        //Autênticação de classe para saber se o usuário e autênticado.
        $this->middleware('auth:admin');    
    }

    public function index()
    {
        $title = 'Forma de pagamento';
        
        $carbon = $this->data_carbon;
        
        //Lista todos pagamentos
        $forma_pag = $this->obj_forma_paga->paginate($this->total_paginas);
        
        return view('formaPagamento.forma_pagamento_view', compact('title', 'forma_pag', 'carbon'));
        
    }

        /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {

        $title = 'Cadastrar';
        
        $objformaPag = $this->obj_forma_paga->paginate($this->total_paginas);
        
        //Rota do formulário
        return view('formaPagamento.create', compact('objformaPag', 'title'));
    }

    public function store(Request $requisicao) {

        $dadosForm = $requisicao->all();
        //dd($dadosForm);

        $this->validate($requisicao, $this->obj_forma_paga->rules);

        $cadastrar = $this->obj_forma_paga->create($dadosForm);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('forma-pagamento.index')->with(['sucesso' => 'Forma de pagamento salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objformaPag = $this->obj_forma_paga->find($id);
        
        $title = "Alterar Forma pagamento";

        //Rota do formulário
        return view('formaPagamento.create', compact('title', 'objformaPag'));
    }

    public function update(Request $requisicao, $id) {

        $this->validate($requisicao, $this->obj_forma_paga->rules);
        $dadosForm = $requisicao->all();

        $alterar = $this->obj_forma_paga->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('forma-pagamento.index')->with(['sucesso' => 'Forma de pagamento Alterado com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Excluir********************************** */

    public function show($id) {

        $objformaPag = $this->obj_forma_paga->find($id);
        //dd($objformaPag);
        $title = "Excluir Forma de pagamento";
        
        $carbon = $this->data_carbon;

        return view('formaPagamento.show', compact('title', 'objformaPag', 'carbon'));
    }

    public function destroy($id) {

        $deletar = $this->obj_forma_paga->find($id)->delete();

        if ($deletar):            
            return redirect()->route('forma-pagamento.index')->with(['sucesso' => 'Forma pagamento excluido com sucesso!']);
            
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }
}
