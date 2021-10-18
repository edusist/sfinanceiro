<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Pagamento;
use Carbon\Carbon;
use App\models\Companie;
use App\models\SubCatPagamento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use App\models\ParcelamentoPagamento;
use App\Http\Controllers\sistema\ParcelamentoController;

class PagamentoController extends Controller {

    private $objPag;
    protected $obj_moeda;
    protected $soma = 0;
    private $total_paginas = 10;
    protected $data_carbon;

    public function __construct(Pagamento $objPagamento, Carbon $carbon) {

        $this->objPag = $objPagamento;
        $this->data_carbon = $carbon;
        $this->middleware('auth:admin');
    }

    public function index() {

        $title = "Contas à Pagar";
        //dd($this->data_carbon->now()->month);
        //dd($this->objPag->PrimeiroDia().'='.$this->objPag->UltimoDia());
        //->whereBetween('pagamentos.data_vencimento', [ '2018-02-28 00:00:00', $this->objPag->UltimoDia()])
        //
        //inner join em 4 tabelas companies, pagamentos, provider, category_pagamentos
        $obj_Pag_tab = DB::table('companies')
                ->join('pagamentos', 'companies.id', '=', 'pagamentos.companie_id')
                ->join('sub_cat_pagamentos', 'pagamentos.subcat_pag_id', '=', 'sub_cat_pagamentos.id')
                ->select('pagamentos.*', 'sub_cat_pagamentos.nome', 'companies.nome_empresa', 'sub_cat_pagamentos.nome')
                ->whereRaw('(MONTH(pagamentos.data_vencimento) = MONTH(CURDATE()))')
                ->OrderBy('pagamentos.data_vencimento')
                ->paginate($this->total_paginas);
        
        //dd($obj_Pag_tab);

        //quantidade de registros
        $quantPagar = DB::table('pagamentos')
                ->select(DB::raw('count(*) as Quant_Pagamentos'))
                ->whereRaw('(MONTH(pagamentos.data_vencimento) = MONTH(CURDATE()))')
                ->get();

        //dd($quant_pagar);
        foreach ($quantPagar as $quant):
            $quant_pag = $quant->Quant_Pagamentos;
        endforeach;

        //Somatório dos contas a pagar
        $soma = $this->somaTrintaDiasPag();
        

        //Recuperando dados da empresa
        $empresa = DB::table('companies')->get(['id', 'nome_empresa']);

        foreach ($empresa as $dados_empr):

            $empresa_id = $dados_empr->id;
            $nome_empresa = $dados_empr->nome_empresa;

        endforeach;

        //Instância da data Carbon
        $data_carbon = $this->data_carbon;

        return view('pagamentos.view_contaPagar', compact('obj_Pag_tab', 'title', 'data_carbon', 'soma', 'quant_pag', 'empresa_id', 'nome_empresa'));
    }

    /*     * ***********************Métodos Somatorio de 30 dias ********************************** */

    public function somaTrintaDiasPag() {
        
        //dd($this->objPag->PrimeiroDia()." -".$this->objPag->UltimoDia());

        $soma = DB::table('pagamentos')
                ->select(DB::raw('sum(valor)as Total'))
                ->whereRaw('(MONTH(pagamentos.data_vencimento) = MONTH(CURDATE()))')
                ->get('valor');
        
        //Converter o array pelo valor float
        foreach ($soma as $valor):
            $soma_total = floatval($valor->Total);
        endforeach;

        return number_format($soma_total, 2, ',', '.');
    }

    /*     * ***********************Métodos para Pesquisar********************************** */

    //Retorna a pesquisa 
    public function informacaoPesquisa(Request $requisicao) {

        $title = "Pesquisa de pagamentos";

        //Recebe o valor da pesquisa 
        $pagar = $this->listaPesquisa($requisicao['pesquisar']);

        //verifica se achou a alguma pesquisa
        if (count($pagar) > 0):

            $pesquisa_pag = array('pesquisar' => $requisicao['pesquisar']);

            $visao = view('pagamentos.lista-pesquisa', compact('pagar', 'pesquisa_pag', 'title'));

            return response($visao);

        else: return redirect()->back()->withErrors(['errors' => 'Pesquisa não encontrada!']);
        endif;
    }

    public function listaPesquisa($pesquisar) {

        //inner join em 4 tabelas companies, pagamentos, providers, category_pagamentos
        return $obj_Rec_tab = DB::table('companies')
                ->join('pagamentos', 'companies.id', '=', 'pagamentos.companie_id')
                ->join('sub_cat_pagamentos', 'pagamentos.subcat_pag_id', '=', 'sub_cat_pagamentos.id')
                ->select('pagamentos.*', 'companies.nome_empresa', 'sub_cat_pagamentos.nome')
                ->where('pagamentos.nome_pagamento', 'LIKE', '%' . $pesquisar . '%')
                ->orWhere('pagamentos.nota_fiscal_cp', 'LIKE', '%' . $pesquisar . '%')
                ->orWhere('sub_cat_pagamentos.nome', 'LIKE', '%' . trim($pesquisar) . '%')
                ->orWhere('pagamentos.valor', 'LIKE', '%' . $pesquisar . '%')
                ->OrderBy('pagamentos.data_vencimento')
                ->simplePaginate(30);
    }

    public function pesquisarPorData() {

        return view('pagamentos.pesquisar-por-data');
    }

    public function postPesquisarPorData(Request $requisicao) {

        $title = "Pagamento Pesquisado";

        $data_form = $requisicao->only(['data-calendario']);

        //dd($data_form);
        $array_data = explode("/", $data_form['data-calendario']);


        $data_formato_bd = $array_data[2] . "-" . $array_data[1] . "-" . $array_data[0];

        $pesquisa_data_venc = DB::table('pagamentos')
                ->join('sub_cat_pagamentos', 'pagamentos.subcat_pag_id', '=', 'sub_cat_pagamentos.id')
                ->select('pagamentos.*', 'sub_cat_pagamentos.nome')
                ->whereDate('data_vencimento', $data_formato_bd)
                ->get();


        //verifica se achou a alguma pesquisa
        if (count($pesquisa_data_venc) > 0):

            $visao = view('pagamentos.lista-pesquisa-data', compact('pesquisa_data_venc', 'title'));

            return response($visao);

        else: return redirect()->back()->withErrors(['errors' => 'Data não encontrada!']);
        endif;
    }

    /*     * ***********************Métodos para Cadastrar********************************** */

    //Filtrar por período
    public function filtroPorPeriodoPagar($id) {


        //Consulta no BD se tem algum pagamento
        $verifica_pag = $this->objPag;

        //conta a quantidade
        $conta_pag = count($verifica_pag);

        //Verifica se existe Recebimento no Bd
        if ($conta_pag == 0):

            return redirect()->back()->withErrors(['errors' => 'Näo existe Pagamentos cadastrado!']);

        else:

            switch ($id) {
                ///////////////////////////////////////Pesquisa  Dia atual/////////////////////////////////////
                case 1:

                    $title = 'Lista do Dia atual de Pagamentos';

                    //Converte no formato do BD
                    $data_formato_bd = $this->data_carbon->now()->format('Y-m-d');

                    $recebi_filtro = $this->listaDiario($data_formato_bd);

                    //Somatório dos valores do pagamentos
                    $soma = DB::table('pagamentos')
                            ->select(DB::raw('sum(valor) as total'))
                            ->whereDate('pagamentos.data_vencimento', $data_formato_bd)
                            ->get('valor');

                    foreach ($soma as $valor):

                        $soma_moeda_real = number_format($valor->total, 2, ',', '.');

                    endforeach;

                    //Quantidade de pagamentos
                    $quant_pag = DB::table('pagamentos')
                            ->select(DB::raw('count(*) as quant'))
                            ->whereDate('pagamentos.data_vencimento', $data_formato_bd)
                            ->get();

                    foreach ($quant_pag as $quant):

                        $quant_pag = $quant->quant;

                    endforeach;

                    return (view('pagamentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_pag', 'title')));

                    break;

                ///////////////////////////////////////Lista da Semana/////////////////////////////////////
                case 2:

                    $title = 'Lista da Semana de Pagamentos';

                    $recebi_filtro = $this->listaSemanal();

                    //quantidade de registros       
                    $quant_pagar = DB::select('select COUNT(*) AS Quant_Pagamentos from pagamentos                                        
                                                where (YEAR(data_vencimento) = YEAR(CURDATE())) 
                                                and (MONTH (data_vencimento) = MONTH (CURDATE())) 
                                                and (WEEK (data_vencimento) = WEEK (CURDATE()))'
                    );

                    foreach ($quant_pagar as $quant):
                        $quant_pag = $quant->Quant_Pagamentos;
                    endforeach;

                    //Total do pagamentos
                    $soma = DB::select('select sum(valor) AS TOTAL from pagamentos                                        
                                        where (YEAR(data_vencimento) = YEAR(CURDATE())) 
                                        and (MONTH (data_vencimento) = MONTH (CURDATE())) 
                                        and (WEEK (data_vencimento) = WEEK (CURDATE()))'
                    );

                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL, 2, ',', '.');

                    endforeach;


                    return (view('pagamentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_pag', 'title')));

                    break;
                ///////////////////////////////////////Lista do mês/////////////////////////////////////
                case 3:
                    $title = 'Lista por mês de Pagamentos';

                    $recebi_filtro = $this->listaMensal();

                    //quantidade de registros  
                    $quant_pagar = DB::select('select COUNT(*) AS Quant_Pagamentos
                                                from pagamentos                                      
                                                where MONTH(data_vencimento) = MONTH(CURDATE())                                      
                                           ');
                    //dd($quant_pagar);
                    foreach ($quant_pagar as $quant):
                        $quant_pag = $quant->Quant_Pagamentos;
                    endforeach;

                    //Total do pagamentos somatório
                    $soma = DB::select('select sum(valor) AS TOTAL
                                        from pagamentos                                      
                                        where MONTH(data_vencimento) = MONTH (CURDATE())                                  
                                        ');
                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL, 2, ',', '.');

                    endforeach;

                    return (view('pagamentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_pag', 'title')));

                    break;
                ///////////////////////////////////////Lista do ano/////////////////////////////////////
                case 4:
                    $title = 'Lista da anual de Pagamentos';

                    $recebi_filtro = $this->listaAnual();

                    //quantidade de registros  
                    $quant_pagar = DB::select('select COUNT(id) AS Quant_Pagamentos from pagamentos                                      
                                                where YEAR(data_vencimento) = YEAR(CURDATE())                                      
                                              ');
                    
                    foreach ($quant_pagar as $quant):
                        $quant_pag = $quant->Quant_Pagamentos;
                    endforeach;

                    //Total do pagamentos somatório
                    $soma = DB::select('select sum(valor) AS TOTAL from pagamentos                                      
                                        where (YEAR(data_vencimento) = YEAR(CURDATE()))                                        
                                        ');
                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL, 2, ',', '.');

                    endforeach;

                    return (view('pagamentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_pag', 'title')));

                    break;

                case 5:
                    $title = 'Todos Pagamentos';

                    $recebi_filtro = $this->listaTodos();

                    $quant_pagar = DB::table('pagamentos')
                            ->select(DB::raw('count(*) as Quant_Pagamentos'))
                            ->get();

                    foreach ($quant_pagar as $quant):
                        $quant_pag = $quant->Quant_Pagamentos;
                    endforeach;

                    $soma = DB::table('pagamentos')
                            ->select(DB::raw('SUM(valor) as TOTAL_PAGAMENTOS'))
                            ->get();

                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL_PAGAMENTOS, 2, ',', '.');

                    endforeach;

                    return (view('pagamentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_pag', 'title')));

                    break;
                default:
                    echo "<script>alert('Escolha uma das opção: Diário, semanal, mensal ou anual!');<script>";
            }
        endif;
    }

    //Filtrar por período lista todos pagamento do dia
    public function listaDiario($data_formato_bd) {

        //Recupera um lista com dados por data atual
        $diario = DB::table('pagamentos')
                ->join('sub_cat_pagamentos', 'sub_cat_pagamentos.id', '=', 'pagamentos.subcat_pag_id')
                ->select('pagamentos.*', 'sub_cat_pagamentos.nome')
                ->whereDate('pagamentos.data_vencimento', $data_formato_bd)
                ->get();
        return $diario;
    }

    //Filtrar por período lista todos pagamento do semana
    public function listaSemanal() {

        $semanal = DB::select('select r.id,  r.data_vencimento, r.nome_pagamento, r.valor, scp.nome, nota_fiscal_cp from pagamentos r
                                        inner join sub_cat_pagamentos scp
                                        on(scp.id = r.subcat_pag_id)
                                        where (YEAR(r.data_vencimento) = YEAR(CURDATE())) 
                                        and (MONTH (r.data_vencimento) = MONTH (CURDATE()) ) 
                                        and (WEEK (r.data_vencimento) = WEEK(CURDATE()))
                                        ORDER BY r.data_vencimento'
        );

        return $semanal;
    }

    //Filtrar por período lista todos pagamento do mês
    public function listaMensal() {

        $mensal = DB::select('select r.id,  r.data_vencimento, r.nome_pagamento, r.valor, scp.nome, nota_fiscal_cp from pagamentos r
                                        inner join sub_cat_pagamentos scp
                                        on(scp.id = r.subcat_pag_id)
                                        where (MONTH (r.data_vencimento) = MONTH (CURDATE()))                                        
                                        ORDER BY r.data_vencimento'
        );

        return $mensal;
    }

    //Filtrar por período lista todos pagamento do ano corrente
    public function listaAnual() {

        $anual = DB::select('select r.id, r.data_vencimento, r.nome_pagamento, r.valor, scp.nome, nota_fiscal_cp from pagamentos r
                                        inner join sub_cat_pagamentos scp
                                        on(scp.id = r.subcat_pag_id)
                                        where (YEAR(r.data_vencimento) = YEAR(CURDATE()))                                        
                                        ORDER BY r.data_vencimento'
        );

        return $anual;
    }

    public function listaTodos() {

        $todos = $this->objPag
                ->paginate($this->total_paginas);
        //dd($todos);

        return $todos;
    }

    public function create() {

        $title = 'Cadastrar';
        $obj_pag = $this->objPag->paginate($this->total_paginas);

        //Recupera o id da empresa
        $empresas = Companie::all('id');
        foreach ($empresas as $empresa):
            $empresa->id;
        endforeach;
        $id_empresa = $empresa->id;

        $obj_cat_pag = SubCatPagamento::all(['id', 'nome']);

        return view('pagamentos.formPagamento', compact('obj_pag', 'title', 'obj_cat_pag', 'id_empresa'));
    }

    public function store(Request $requisicao) {

        /*
          Status
          0 - em aberto
          1 - pago
          2 - atrasado
         */

        $valor = $requisicao->input('valor');

        $obj_moeda_real = new MoedaMundialController();

        $valor_bd = $obj_moeda_real->formatoBd($valor);
        //dd($valor_bd);
        //Recupera valores do formulário
        $nome_pagamento = $requisicao->input('nome_pagamento');
        $nota_fiscal = $requisicao->input('nota_fiscal_cp');
        $status = $requisicao->input('status');
        $descricao = $requisicao->input('descricao');
        $empresa = $requisicao->input('companie_id');
        $categoria = $requisicao->input('subcat_pag_id');
        $data_vencimento = $requisicao->input('data_vencimento');

        //converte data no padrão UTC-mundial
        $data_array = explode('/', $data_vencimento);
        $data_formato_Bd = $data_array[2] . '-' . $data_array[1] . '-' . $data_array[0];

        $ret_data = $this->data_carbon->parse($data_formato_Bd)->format('Y-m-d H:i:s');

        //Salva valores recuperados do formulário que usuário digitou
        $cadastrar = $this->objPag->create([
            'nome_pagamento' => $nome_pagamento,
            'nota_fiscal_cp' => $nota_fiscal,
            'valor' => $valor_bd,
            'status' => $status,
            'descricao' => $descricao,
            'companie_id' => $empresa,
            'subcat_pag_id' => $categoria,
            'data_vencimento' => $ret_data,
        ]);

        //dd($cadastrar);
        if ($cadastrar):

            //Rota do index dentro do controller
            return redirect()->route('pagamento.index')->with(['sucesso' => 'Pagamento salvo com sucesso!']);

        else:
            return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * ******************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $obj_pag = $this->objPag->find($id);
        //dd($obj_pag );
        $title = "Alterar pagamento: {$obj_pag->nome_pagamento}";

        //Instância da classe fornecedor
        //$obj_fornecedor = DB::table('providers')->get(['id', 'nome_fornecedor']);
        //Instância da classe Categoria de pagamentos
        $obj_cat_pag = DB::table('sub_cat_pagamentos')->get(['id', 'nome']);

        //Rota do formulário
        return view('pagamentos.formPagamento', compact('title', 'obj_pag', 'obj_cat_pag'));
    }

    public function update(Request $requisicao, $id) {

        //Recupera o status atual
        $status_atual = DB::table('pagamentos')
                ->select('pagamentos.status')
                ->where('id', '=', $id)
                ->get('status');

        foreach ($status_atual as $status):

            $status = $status->status;
        endforeach;

        $nome_pagamento = $requisicao->input('nome_pagamento');
        $valor = $requisicao->input('valor');
        $descricao = $requisicao->input('descricao');
        $empresa = $requisicao->input('companie_id');
        $categoria = $requisicao->input('subcat_pag_id');
        $data_vencimento = $requisicao->input('data_vencimento');

        //dd($requisicao->only('status'));

        $this->validate($requisicao, $this->objPag->rules);

        //Converter na data formato bd EUA
//        $array_data = explode("/", $data_vencimento);
//
//        $data_formato_bd = $array_data[2] . "-" . $array_data[1] . "-" . $array_data[0];
        ///dd($data_formato_bd);

        $alterar = $this->objPag->find($id)->update([
            'nome_pagamento' => $nome_pagamento,
            'valor' => $valor,
            'status' => $status,
            'descricao' => $descricao,
            'companie_id' => $empresa,
            'subcat_pag_id' => $categoria,
            'data_vencimento' => $data_vencimento,
        ]);

        if ($alterar):

            return redirect()->route('pagamento.index')->with(['sucesso' => 'Pagamento alterado com sucesso!']);

        else:

            return redirect()->withErrors(['errors' => 'Näo possivel alterar!']);
        endif;
    }

    /*     * *****************************Métodos para Excluir********************************** */

    public function getExcluirTodasPag() {

        $title = 'Excluir todos os pagamentos';

        $obj_pag = DB::table('pagamentos')
                ->join('sub_cat_pagamentos', 'pagamentos.subcat_pag_id', '=', 'sub_cat_pagamentos.id')
                ->select('pagamentos.*', 'sub_cat_pagamentos.nome')
                ->OrderBy('pagamentos.data_vencimento')
                ->get();

        //quantidade de registros       
        $quant_pagar = DB::table('pagamentos')
                ->select(DB::raw('count(*) as Quant_Pagamentos'))
                ->get();

        foreach ($quant_pagar as $quant):
            $quant_pag = $quant->Quant_Pagamentos;
        endforeach;

        //quantidade de registros       
        $soma = DB::table('pagamentos')
                ->select(DB::raw('sum(valor) as SOMA_TOTAL'))
                ->get();

        foreach ($soma as $valor_soma):

            $soma_moeda_real = number_format($valor_soma->SOMA_TOTAL, 2, ',', '.');

        endforeach;

//         dd($soma_moeda_real);

        return view('pagamentos.excluir-todos-pag', compact('obj_pag', 'title', '$quant_pagar', 'quant_pag', 'soma_moeda_real'));
    }

    //Exclui todos os registros
    public function DeleteTodasPag() {
        //dd('excluir');

        $deletar = DB::table('pagamentos')->delete();

        if ($deletar):

            return redirect()->route('pagamento.index')->with(['sucesso' => 'Todos Pagamentos excluidos com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

    public function show($id) {

        //Procura pelo id dentro da tabela pagamento
        $obj_pag = $this->objPag->find($id);

        $title = "Excluir pagamento {$obj_pag->nome_pagamento}";

        $data_carbon = $this->data_carbon;

        //Rota do formulário 
        return view('pagamentos.show', compact('title', 'obj_pag', 'data_carbon'));
    }

    public function destroy($id) {

        $deletar = $this->objPag->find($id)->delete();

        if ($deletar):

            return redirect()->route('pagamento.index')->with(['sucesso' => 'Pagamento excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

    //Relatorio pdf
    public function pdf(PDF $pdf) {

        $pagar = $this->objPag->all();
        $soma_moeda_real = $this->objPag->somaPagamento();
        $pdf_pag = $pdf->loadView('pagamentos/pagar_pdf', ['pagar' => $pagar, 'soma_moeda_real' => $soma_moeda_real])
                ->setPaper('a4', 'landscape')
                ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return $pdf_pag->download('relatorio_pagamentos.pdf');
    }

    /*     * ****************************Métodos para Parcelamento********************************** */

    public function pagarParcelamento($id) {

        $obj_pag = $this->objPag->paginate($this->total_paginas);

        $title = 'Cadastrar parcelamento';

        $parcelamentos = ['Semanal', 'Quinzenal', 'Mensal', 'Anual'];
        //Companie::all()->find($id);
        $empresa = Companie::all()->find($id);
        $id_empresa = $empresa->id;

        //Instância da classe fornecedor
        //$obj_fornecedor = DB::table('providers')->get(['id', 'nome_fornecedor']);
        //Instância da classe Categoria de pagamento
        $obj_cat_pag = DB::table('sub_cat_pagamentos')->get(['id', 'nome']);

        //Rota do formulário
        return view('pagamentos.formCadParcelamentoPag', compact('obj_pag', 'obj_cat_pag', 'title', 'parcelamentos', 'id_empresa'));
    }

    public function postParcelamentoPag(Request $requisicao) {
        //dd($requisicao->all());
        //Validação dos campos de formulário
        $this->validate($requisicao, [
            'nome_pagamento' => 'required|max:50',
            'valor' => 'required',
            'quant_parcelas' => 'required',
            'nome_parcela' => 'required',
            'descricao' => 'max:100',
            'data_vencimento' => 'required',
            'subcat_pag_id' => 'required'
        ]);

        //dd($valid);
        //Guarda os valores recuperados no formulário em cada variavel
        $nome_parcela = $requisicao->input('nome_parcela');
        $quant_parcela = $requisicao->input('quant_parcelas');
        $nome_pagamento = $requisicao->input('nome_pagamento');
        $status = $requisicao->input('status');
        $nota_fiscal_cp = $requisicao->input('nota_fiscal_cp');
        $valor = $requisicao->input('valor');
        $descricao = $requisicao->input('descricao');
        $empresa = $requisicao->input('companie_id');
        $categoria = $requisicao->input('subcat_pag_id');
        $data_vencimento = $requisicao->input('data_vencimento');

        //Converte para moeda no padrão mundial do Bd
        $obj_moeda_real = new MoedaMundialController();        
        $valor_bd = $obj_moeda_real->formatoBd($valor);

        //Chamada função para opção de parcelamento
        $retorno_parcelas = $this->menuTipoParcelamento($data_vencimento, $nome_parcela, $quant_parcela);

        foreach ($retorno_parcelas as $key => $ret_data_vencimento):

            //converte data no padrão UTC-mundial
            $ret_data = $this->data_carbon->parse($ret_data_vencimento)->format('Y-m-d H:m:s');

            //Salva valores recuperados do formulário que usuário digitou
            $retorno_pag = $this->objPag->create([
                'data_vencimento' => $ret_data,
                'nome_pagamento' => $nome_pagamento,
                'nota_fiscal_cp' => $nota_fiscal_cp,
                'valor' => $valor_bd,
                'status' => $status,
                'quant_parcelas' => $quant_parcela,
                'descricao' => $descricao,
                'companie_id' => $empresa,
                'subcat_pag_id' => $categoria,
            ]);

            if ($retorno_pag):

                print_r("Salva com sucesso" . $retorno_pag);

            endif;

            //Instância da Model ParcelmentoPagamento
            $parcelamentos_pagar = new ParcelamentoPagamento();
            //dd($parcelamentos);
            //Recupera o id de cada pagamento gerado pelo sistema
            $parcelamentos_pagar->pagamento_id = $retorno_pag->id;

            //dd($parcelamentos_pagar);
            //Salva na tabela parcelamento
            $salva_parcelamento = $parcelamentos_pagar->create([
                'nome_parcela' => $nome_parcela,
                'quant_parcelas' => $quant_parcela,
                'pagamento_id' => $parcelamentos_pagar->pagamento_id
            ]);

        endforeach;

        if ($salva_parcelamento):
            return redirect()->route('pagamento.index')->with(['sucesso' => 'Parcelamento do pagamento salva com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel salvar parcelamento']);

        endif;
    }

    public function menuTipoParcelamento($data_vencimento, $nome_parcela, $quant_parcela) {

        //dd($data_vencimento);
        $dt = explode("/", $data_vencimento); //retira a barra no e  quebra em um array                  

        $ano = $dt[2];
        $mes = $dt[1];
        $dia = $dt[0];
        //'Semanal', 'Quinzenal', 'Mensal', 'Anual'
        //var_dump($ano.$mes.$dia);
        $this->objParcelas = new ParcelamentoController($ano, $mes, $dia, $quant_parcela);

        switch ($nome_parcela) {

            case 'Diario';

                $Arr_diario = $this->objParcelas->parcelaDiariamente();
                return $Arr_diario;

                break;
            case 'Semanal';

                $Arr_semanal = $this->objParcelas->parcelaSemanal();
                return $Arr_semanal;

                break;
            case 'Quinzenal';

                $Arr_Quinzenal = $this->objParcelas->parcelaQuinzenal();
                //dd($Arr_Quinzenal);
                return $Arr_Quinzenal;

                break;
            case 'Mensal';

                $Arr_Mensal = $this->objParcelas->parcelaMensal();
                return $Arr_Mensal;

                break;
            case 'Bimestral ';

                $Arr_Bimestral = $this->objParcelas->parcelaBimestral();
                return $Arr_Bimestral;

                break;
            case 'Trimestral';

                $Arr_Trimestral = $this->objParcelas->parcelaTrimestral();
                return $Arr_Trimestral;

                break;
            case 'Semestral';

                $Arr_Semestral = $this->objParcelas->parcelaSemestral();
                return $Arr_Semestral;

                break;
            case 'Anual';
                $Arr_Anual = $this->objParcelas->parcelaAnual();
                return $Arr_Anual;

                break;
            default:
                echo "<script> alert('Escolha uma opção entre 1 à 8!'); </script>";
        }
    }

}
