<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Companie;
use Carbon\Carbon;
use App\models\Cidade;
use Illuminate\Support\Facades\DB;

class CompanieController extends Controller {

    private $obj_empresa;
    private $total_paginas = 8; //Valor para paginação
    protected $obj_carbon;

    /*     * ********************************Método Contrutor da classe********************************** */

    public function __construct(Companie $obModelCompanie, Carbon $carbon) {

        $this->obj_empresa = $obModelCompanie;
        //Autênticação de classe para saber se o usuário e autênticado.
        $this->middleware('auth:admin');
        $this->obj_carbon = $carbon;
    }

    /*     * ********************************Métodos para Listar********************************** */

    public function index() {

        $title = 'Empresa';
        $objEmpresa = $this->obj_empresa->paginate($this->total_paginas);
        $carbon = $this->obj_carbon;


        //Rota do formulário
        return view('empresas.empresasview', compact('objEmpresa', 'title', 'carbon'));
    }

    /*     * ********************************Métodos para Cadastrar********************************** */

    public function create() {

        $title = 'Cadastrar';
        
        $objEmpresa = $this->obj_empresa->paginate($this->total_paginas);

        return view('empresas.create', compact('objEmpresa', 'title'));
    }

    public function store(Request $requisicao) {
        
        //Validação do formulário
        $this->validate($requisicao, $this->obj_empresa->rules);

        //dd($requisicao->all());
        //Recupera todos o campos que usuário preencheu
        $nome_empresa     = $requisicao->input('nome_empresa');
        $cnpj_cpf         = $requisicao->input('cnpj_cpf');
        $email            = $requisicao->input('email');
        $telefone_fixo    = $requisicao->input('telefone_fixo');
        $telefone_celular = $requisicao->input('telefone_celular'); 
        $endereco         = $requisicao->input('endereco');
        $numero           = $requisicao->input('numero');
        $bairro           = $requisicao->input('bairro');
        $complemento      = $requisicao->input('complemento');
        $uf               = $requisicao->input('uf');
        $cidade           = $requisicao->input('cidade');
        $descricao        = $requisicao->input('descricao');  
        
        // $nome_cidade = DB::table('cidades')
        //                         ->select('cidades.nome')
        //                         ->where('id', '=', $id_cidade)->get(['nome']);
        
        //         foreach ($nome_cidade as $nome):
                    
        //             $nome_cidade = $nome->nome;
                    
                    
        //         endforeach;
        //dd($nome_cidade);
        
        $cadastrar = $this->obj_empresa->create([
            
            'nome_empresa'    => $nome_empresa,
            'cnpj_cpf'        =>$cnpj_cpf,
            'email'           => $email,
            'telefone_fixo'   => $telefone_fixo,
            'telefone_celular'=> $telefone_celular,            
            'endereco'        => $endereco,
            'numero'          => $numero,
            'complemento'     => $complemento,
            'bairro'          => $bairro,            
            'cidade'          => $cidade, 
            'uf'              => $uf,
            'descricao'       => 'descricao',
            'cidade_id'       => 0 //$id_cidade
        ]);
        
        //dd($cadastrar);

        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('empresa.index')->with(['sucesso' => 'Empresa salva com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ********************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $objEmpresa = $this->obj_empresa->find($id);

        $title = "Alterar";

        //Rota do formulário
        return view('empresas.create', compact('title', 'objEmpresa'));
    }

    public function update(Request $request, $id) {

        $this->validate($request, $this->obj_empresa->rules);
        $dadosForm = $request->all();

        $alterar = $this->obj_empresa->find($id)->update($dadosForm);

        if ($alterar):

            return redirect()->route('empresa.index')->with(['sucesso' => 'Empresa alterada com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * *******************************Métodos para Excluir********************************** */

    public function show($id) {

        $objEmpresa = $this->obj_empresa->find($id);
        $title = "Excluir {$objEmpresa->nome}";

        return view('empresas.show', compact('title', 'objEmpresa'));
    }

    public function destroy($id) {

        $deletar = $this->obj_empresa->find($id)->delete();

        if ($deletar):

            return redirect()->route('empresa.index')->with(['sucesso' => 'Empresa excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

}

//        $cidades = Cidade::all(['id', 'nome_cidade']);//
//        $estados = Estado::all(['id', 'nome_estado']); 