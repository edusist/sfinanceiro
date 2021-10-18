<?php

namespace App\Http\Controllers\sistema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\models\Receipt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use App\Http\Controllers\sistema\ParcelamentoController;
use App\models\ParcelamentoRecebimento;
use App\models\Companie;

class receiptsController extends Controller {

    protected $objRec;
    protected $obj_moeda;
    protected $soma = 0;
    private $total_paginas = 10; //Valor para paginação
    private $data_carbon;

    public function __construct(Receipt $objRecebimento, Carbon $carbon) {

        $this->objRec = $objRecebimento;
        $this->data_carbon = $carbon;
        $this->middleware('auth:admin');
    }

    //Listar os recebimentos
    public function index() {

        /*
          Status
          0 - em aberto
          1 - pago
          2 - atrasado
         */

        $title = "Contas à Receber";

        //dd([$this->objRec->PrimeiroDia(), $this->objRec->UltimoDia()]);
        //inner join em 4 tabelas companies, receipts, customers, sub_cat_recebimentos
        $obj_Rec_tab = DB::table('receipts')
                ->join('sub_cat_recebimentos', 'sub_cat_recebimentos.id', '=', 'receipts.subcat_rec_id')
                ->join('companies', 'companies.id', '=', 'receipts.companie_id')
                ->select('receipts.*', 'companies.nome_empresa', 'sub_cat_recebimentos.nome')
                ->whereRaw('(MONTH(receipts.data_vencimento) = MONTH(CURDATE()))')
                ->OrderBy('receipts.data_vencimento')
                ->paginate($this->total_paginas);


        //dd($obj_Rec_tab);
        //Testa os boletos em atraso 
        foreach ($obj_Rec_tab as $valor):

            $data_vencimento = $this->data_carbon->parse($valor->data_vencimento)->format('Y-m-d');
            $id_recebimento = $valor->id;

            $status_atual = $valor->status;

            //Testa o status se for diferente de 1 entra e alterar o status
            if ($status_atual != '1'):

                $data_atual = $this->objRec->dataAtualBd();

                //Se a data_vencimento for menor que data atual está em atraso
                if (strtotime($data_vencimento) < strtotime($data_atual)):


                    //Altera o status para 2 se estiver atrasado
                    $this->statusAtrasado($id_recebimento);

                else://Entra dentro do else se a data vencimento for igual a data atual 
                    //dd('entro no else');
                    //quantidade de registros       
                    $quant_receber = DB::table('receipts')
                            ->select(DB::raw('count(*) as Quant_Recebimentos'))
                            ->whereRaw('(MONTH(receipts.data_vencimento) = MONTH(CURDATE()))')
                            ->get();

                    foreach ($quant_receber as $quant):
                        $quant_rec = $quant->Quant_Recebimentos;
                    endforeach;

                    //Chama a função para somar todos os valores de recebimentos 
                    $soma_moeda_real = $this->somaTrintaDias();

                    $empresa = Companie::all();

                    $empresa_cadastrada = count($empresa);

                    //Verifica se tem alguma empresa cadastrada
                    if ($empresa_cadastrada == 0):

                        return redirect()->route('empresa.index')->withErrors(['errors' => 'Necessário Cadastrar uma nova empresa!']);

                    else:

                        //Recuperando dados da empresa
                        $empresa = DB::table('companies')->get(['id', 'nome_empresa']);

                        foreach ($empresa as $dados_empr):

                            $empresa_id = $dados_empr->id;
                            $nome_empresa = $dados_empr->nome_empresa;
                            //dd($empresa_id);

                        endforeach;

                    //dd($nome_empresa);

                    endif; //Fim do if de cadastrar empresa
                    //Instância da data Carbon
                    $data_carbon = $this->data_carbon;

                    return(view('recebimentos.view_contaReceber', compact('obj_Rec_tab', 'title', 'soma_moeda_real', 'data_carbon', 'empresa_id', 'nome_empresa', 'quant_rec')));


                endif;
            endif;
        endforeach;

        //quantidade de registros       
        $quant_receber = DB::table('receipts')
                ->select(DB::raw('count(*) as Quant_Recebimentos'))
                ->whereRaw('(MONTH(receipts.data_vencimento) = MONTH(CURDATE()))')
                ->get();

        foreach ($quant_receber as $quant):
            $quant_rec = $quant->Quant_Recebimentos;
        endforeach;

        //Chama a função para somar todos os valores de recebimentos 
        $soma_moeda_real = $this->somaTrintaDias();

        $empresa = Companie::all();

        $empresa_cadastrada = count($empresa);

        //Verifica se tem alguma empresa cadastrada
        if ($empresa_cadastrada == 0):

            return redirect()->route('empresa.index')->withErrors(['errors' => 'Necessário Cadastrar uma nova empresa!']);

        else:

            //Recuperando dados da empresa
            $empresa = DB::table('companies')->get(['id', 'nome_empresa']);

            foreach ($empresa as $dados_empr):

                $empresa_id = $dados_empr->id;
                $nome_empresa = $dados_empr->nome_empresa;
                //dd($empresa_id);

            endforeach;

        endif; //Fim do if de cadastrar empresa
        //Instância da data Carbon
        $data_carbon = $this->data_carbon;

        return(view('recebimentos.view_contaReceber', compact('obj_Rec_tab', 'title', 'soma_moeda_real', 'data_carbon', 'empresa_id', 'nome_empresa', 'quant_rec')));
    }

    public function cadEmpresa() {

        //Recuperando dados da empresa
        $empresa = DB::table('companies')->get(['id', 'nome_empresa']);

        foreach ($empresa as $dados_empr):
            return $dados_empr;
        endforeach;
    }

    //Relatorio pdf
    public function pdf(PDF $pdf) {

        $receber = $this->objRec->all();
        $soma_moeda_real = $this->somaRecebimentos();
        $pdfcliente = $pdf->loadView('recebimentos/receber_pdf', ['receber' => $receber, 'soma_moeda_real' => $soma_moeda_real])
                ->setPaper('a4', 'landscape')
                ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return $pdfcliente->download('relatorio_recebimentos.pdf');
    }

    //Retorna a pesquisa 
    public function informacaoPesquisaRec(Request $requisicao) {

        $title = "Pesquisa de Recebimento";

        //dd($requisicao['pesquisar']);
        //Receber o valor da pesquisa 
        $receber = $this->listaPesquisa($requisicao['pesquisar']);

        //verifica se achou a alguma pesquisa
        if (count($receber) > 0):

            $pesquisa_rec = array('pesquisar' => $requisicao['pesquisar']);


            $visao = view('recebimentos.lista-pesquisa', compact('receber', 'pesquisa_rec', 'title'));

            //dd($visao);

            return response($visao);

        else: return redirect()->back()->withErrors(['errors' => 'Pesquisa não encontrada!']);
        endif;
    }

    public function listaPesquisa($pesquisar) {

        //inner join em 4 tabelas companies, receipts, customers, sub_cat_recebimentos
        //return
        return $obj_Rec_tab = DB::table('companies')
                ->join('receipts', 'companies.id', '=', 'receipts.companie_id')
                ->join('sub_cat_recebimentos', 'sub_cat_recebimentos.id', '=', 'receipts.subcat_rec_id')
                ->select('receipts.*', 'companies.nome_empresa', 'sub_cat_recebimentos.nome')
                ->where('receipts.nome_recebimento', 'LIKE', '%' . ucfirst(trim($pesquisar)) . '%')//Converter 1º caracter em maiuscula.
                ->orWhere('receipts.nota_fiscal_cr', 'LIKE', '%' . trim($pesquisar) . '%')//Retira os espaços em branco
                ->orWhere('receipts.valor', 'LIKE', '%' . trim($pesquisar) . '%')
                ->orWhere('sub_cat_recebimentos.nome', 'LIKE', '%' . trim($pesquisar) . '%')
                ->OrderBy('receipts.data_vencimento')
                ->paginate($this->total_paginas);
    }

    //Filtrar por período
    public function filtroPorPeriodo($id) {

        //Consulta no BD se tem algum recebimento
        $verifica_rec = $this->objRec->all();

        //conta a quantidade
        $conta_rec = count($verifica_rec);

        //Verifica se existe Recebimento no Bd
        if ($conta_rec == 0):
            return redirect()->back()->withErrors(['errors' => 'Näo existe Recebimento cadastrado!']);

        else:

            switch ($id) {
                ///////////////////////////////////////Pesquisa  Dia atual/////////////////////////////////////
                case 1:

                    $title = 'Lista do Dia atual';

                    //Converte no formato do BD
                    $data_formato_bd = $this->data_carbon->now()->format('Y-m-d');

                    $recebi_filtro = $this->listaDiario($data_formato_bd);

                    //Somatório dos valores do recebimentos
                    $soma = DB::table('receipts')
                            ->select(DB::raw('sum(valor) as total'))
                            ->whereDate('receipts.data_vencimento', $data_formato_bd)
                            ->get('valor');

                    foreach ($soma as $valor):

                        $soma_moeda_real = number_format($valor->total, 2, ',', '.');

                    endforeach;

                    //Quantidade de recebimentos
                    $quant_rec = DB::table('receipts')
                            ->select(DB::raw('count(*) as quant'))
                            ->whereDate('receipts.data_vencimento', $data_formato_bd)
                            ->get();

                    foreach ($quant_rec as $quant):

                        $quant_rec = $quant->quant;

                    endforeach;

                    return (view('recebimentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_rec', 'title')));

                    break;

                ///////////////////////////////////////Lista da Semana/////////////////////////////////////
                case 2:

                    $title = 'Lista da Semana';

                    $recebi_filtro = $this->listaSemanal();

                    //quantidade de registros       
                    $quant_receber = DB::select('select COUNT(*) AS Quant_Recebimentos from receipts                                        
                                                where (YEAR(data_vencimento) = YEAR(CURDATE())) 
                                                and (MONTH (data_vencimento) = MONTH (CURDATE())) 
                                                and (WEEK (data_vencimento) = WEEK (CURDATE()))'
                    );

                    foreach ($quant_receber as $quant):
                        $quant_rec = $quant->Quant_Recebimentos;
                    endforeach;

                    //Total do recebimentos
                    $soma = DB::select('select sum(valor) AS TOTAL from receipts                                        
                                        where (YEAR(data_vencimento) = YEAR(CURDATE())) 
                                        and (MONTH (data_vencimento) = MONTH (CURDATE())) 
                                        and (WEEK (data_vencimento) = WEEK (CURDATE()))'
                    );

                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL, 2, ',', '.');

                    endforeach;


                    return (view('recebimentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_rec', 'title')));

                    break;
                ///////////////////////////////////////Lista do mês/////////////////////////////////////
                case 3:
                    $title = 'Lista do mês';

                    $recebi_filtro = $this->listaMensal();

                    //quantidade de registros  
                    $quant_receber = DB::select('select COUNT(*) AS Quant_Recebimentos
                                                from receipts                                      
                                                where MONTH(data_vencimento) = MONTH(CURDATE())                                      
                                           ');
                    //dd($quant_receber);
                    foreach ($quant_receber as $quant):
                        $quant_rec = $quant->Quant_Recebimentos;
                    endforeach;

                    //Total do recebimentos somatório
                    $soma = DB::select('select sum(valor) AS TOTAL
                                        from receipts                                      
                                        where MONTH(data_vencimento) = MONTH (CURDATE())                                  
                                        ');
                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL, 2, ',', '.');

                    endforeach;

                    return (view('recebimentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_rec', 'title')));

                    break;
                ///////////////////////////////////////Lista do ano/////////////////////////////////////
                case 4:
                    $title = 'Lista do ano Corrente';

                    $recebi_filtro = $this->listaAnual();

                    //quantidade de registros  
                    $quant_receber = DB::select('select COUNT(id) AS Quant_Recebimentos from receipts                                      
                                        where (YEAR(data_vencimento) = YEAR(CURDATE()))                                        
                                        ');
                    foreach ($quant_receber as $quant):
                        $quant_rec = $quant->Quant_Recebimentos;
                    endforeach;

                    //Total do recebimentos somatório
                    $soma = DB::select('select sum(valor) AS TOTAL from receipts                                      
                                        where (YEAR(data_vencimento) = YEAR(CURDATE()))                                        
                                        ');
                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL, 2, ',', '.');

                    endforeach;

                    return (view('recebimentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_rec', 'title')));

                    break;

                case 5:
                    $title = 'Todos Recebimentos';

                    $recebi_filtro = $this->listaTodos();

                    $quant_rec = DB::table('receipts')
                            ->select(DB::raw('count(*) as Quant_Recebimentos'))
                            ->get();

                    foreach ($quant_rec as $quant):
                        $quant_rec = $quant->Quant_Recebimentos;
                    endforeach;

                    $soma = DB::table('receipts')
                            ->select(DB::raw('SUM(valor) as TOTAL_RECEBIMENTOS'))
                            ->get();

                    foreach ($soma as $total):

                        $soma_moeda_real = number_format($total->TOTAL_RECEBIMENTOS, 2, ',', '.');

                    endforeach;

                    return (view('recebimentos.filtro_por_periodo', compact('recebi_filtro', 'soma_moeda_real', 'quant_rec', 'title')));

                    break;

                default:
                    echo "<script>alert('Escolha uma das opção: Diário, semanal, mensal ou anual!');<script>";
            }

        endif; //fim do if verifica vazio
    }

    //Filtrar por período lista todos recebimento do dia
    public function listaDiario($data_formato_bd) {

        //Recupera um lista com dados por data atual
        $diario = DB::table('receipts')
                ->join('sub_cat_recebimentos', 'sub_cat_recebimentos.id', '=', 'receipts.subcat_rec_id')
                ->select('receipts.*', 'sub_cat_recebimentos.nome')
                ->whereDate('receipts.data_vencimento', $data_formato_bd)
                ->get();
        return $diario;
    }

    //Filtrar por período lista todos recebimento do semana
    public function listaSemanal() {

        $semanal = DB::select('select r.id,  r.data_vencimento, r.nome_recebimento, r.valor, scp.nome, nota_fiscal_cr from receipts r
                                        inner join sub_cat_recebimentos scp
                                        on(scp.id = r.subcat_rec_id)
                                        where (YEAR(r.data_vencimento) = YEAR(CURDATE())) 
                                        and (MONTH (r.data_vencimento) = MONTH (CURDATE()) ) 
                                        and (WEEK (r.data_vencimento) = WEEK(CURDATE()))
                                        ORDER BY r.data_vencimento'
        );

        return $semanal;
    }

    //Filtrar por período lista todos recebimento do mês
    public function listaMensal() {

        $mensal = DB::select('select r.id,  r.data_vencimento, r.nome_recebimento, r.valor, scp.nome, nota_fiscal_cr from receipts r
                                        inner join sub_cat_recebimentos scp
                                        on(scp.id = r.subcat_rec_id)
                                        where (MONTH (r.data_vencimento) = MONTH (CURDATE()))                                        
                                        ORDER BY r.data_vencimento'
        );

        return $mensal;
    }

    //Filtrar por período lista todos recebimento do ano corrente
    public function listaAnual() {

        $anual = DB::select('select r.id,  r.data_vencimento, r.nome_recebimento, r.valor, scp.nome, nota_fiscal_cr from receipts r
                                        inner join sub_cat_recebimentos scp
                                        on(scp.id = r.subcat_rec_id)
                                        where (YEAR(r.data_vencimento) = YEAR(CURDATE()))                                        
                                        ORDER BY r.data_vencimento'
        );

        return $anual;
    }

    public function listaTodos() {

        $todos = $this->objRec
                ->paginate($this->total_paginas);

        return $todos;
    }

    //Pesquisa por data rcalendário
    public function pesquisarDataReceber() {

        return view('recebimentos.pesquisar-por-data-rec');
    }

    public function postPesquisarDataReceber(Request $requisicao) {

        $title = "Recebimento Pesquisado";

        $data_form = $requisicao->only(['data-calendario']);

        $array_data = explode("/", $data_form['data-calendario']);

        $data_formato_bd = $array_data[2] . "-" . $array_data[1] . "-" . $array_data[0];

        $pesquisa_data_venc = DB::table('receipts')
                ->join('sub_cat_recebimentos', 'receipts.subcat_rec_id', '=', 'sub_cat_recebimentos.id')
                ->select('receipts.*', 'sub_cat_recebimentos.nome')
                ->whereDate('receipts.data_vencimento', $data_formato_bd)
                ->get();


        //verifica se achou a alguma pesquisa
        if (count($pesquisa_data_venc) > 0):

            $visao = view('recebimentos.lista-pesquisa-data-receber', compact('pesquisa_data_venc', 'title'));

            return response($visao);

        else: return redirect()->back()->withErrors(['errors' => 'Data não encontrada!']);
        endif;
    }

    /*     * *************************Métodos para Cadastrar********************************** */

    public function create() {

        $obj_rec = $this->objRec->paginate($this->total_paginas);
        $title = 'Cadastrar';

        //Instância da classe Empresas
        $empresas = Companie::all('id');
        foreach ($empresas as $empresa):
            $empresa->id;
        endforeach;
        $id_empresa = $empresa->id;

        //Instância da classe Categoria de recebimentos
        $obj_cat_rec = DB::table('sub_cat_recebimentos')->get(['id', 'nome']);

        //Rota do formulário
        return view('recebimentos.formCadastro', compact('obj_rec', 'obj_cat_rec', 'title', 'id_empresa'));
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

        // dd($valor_bd);
        //Recupera valores do formulário
        $nome_recebimento = $requisicao->input('nome_recebimento');
        $nota_fiscal = $requisicao->input('nota_fiscal_cr'); //aceita valor Null       
        $status = $requisicao->input('status');
        $descricao = $requisicao->input('descricao');
        $empresa = $requisicao->input('companie_id');
        $categoria = $requisicao->input('subcat_rec_id');
        $data_vencimento = $requisicao->input('data_vencimento');

        //dd($data_vencimento);
        //converte data no padrão UTC-mundial
        $data_array = explode('/', $data_vencimento);
        $data_formato_Bd = $data_array[2] . '-' . $data_array[1] . '-' . $data_array[0];

        $ret_data = $this->data_carbon->parse($data_formato_Bd)->format('Y-m-d');

        //Recupera a data de hoje
        $data_atual = $this->objRec->dataAtualBd();
        //dd($data_atual.''.$ret_data);
        //Se a data_vencimento for menor que data atual está em atraso
        //verifica data atrasa
        if (strtotime($ret_data) < strtotime($data_atual)):

            $status = 2;

            //Salva valores recuperados do formulário que usuário digitou
            $cadastrar = $this->objRec->create([
                'nome_recebimento' => $nome_recebimento,
                'nota_fiscal_cr' => $nota_fiscal,
                'valor' => $valor_bd,
                'status' => $status,
                'descricao' => $descricao,
                'companie_id' => $empresa,
                'subcat_rec_id' => $categoria,
                'data_vencimento' => $ret_data,
            ]);
            /////////////////////////////////Cadastro se atrasado ////////////////////////////////////////////
            if ($cadastrar):

                //Rota do index dentro do controller
                return redirect()->route('recebimento.index')->with(['sucesso' => 'Recebimento salvo com sucesso!']);

            else:
                return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

            endif;

        /////////////////////////////////Cadastro de Não atrasado ////////////////////////////////////////////
        else://verifica data atrasa
            //Salva valores recuperados do formulário que usuário digitou
            $cadastrar = $this->objRec->create([
                'nome_recebimento' => $nome_recebimento,
                'nota_fiscal_cr' => $nota_fiscal,
                'valor' => $valor_bd,
                'status' => $status,
                'descricao' => $descricao,
                'companie_id' => $empresa,
                'subcat_rec_id' => $categoria,
                'data_vencimento' => $ret_data,
            ]);

            if ($cadastrar):

                //Rota do index dentro do controller
                return redirect()->route('recebimento.index')->with(['sucesso' => 'Recebimento salvo com sucesso!']);

            else:
                return redirect()->back()->withErrors(['errors' => 'Näo possivel alterar!']);

            endif; //fim if cadastra

        endif; //fim if verifica data atrasa
    }

    /*     * ******************************Métodos para Editar********************************** */

    public function edit($id) {

        //Carrega 1 Objeto Json pelo Id, para preencher o formulário para editar 
        $obj_rec = $this->objRec->find($id);

        $title = "Alterar  Recebimento: {$obj_rec->nome_recebimento}";

        //Instância da classe Categoria de recebimentos
        $obj_cat_rec = DB::table('sub_cat_recebimentos')->get(['id', 'nome']);

        //Rota do formulário
        return view('recebimentos.formCadastro', compact('title', 'obj_rec', 'obj_cat_rec'));
    }

    public function update(Request $requisicao, $id) {


        //Recupera o status atual
        $status_atual = DB::table('receipts')
                ->select('receipts.status')
                ->where('id', '=', $id)
                ->get('status');

        foreach ($status_atual as $status):

            $status = $status->status;
        endforeach;

        $nome_recebimento = $requisicao->input('nome_recebimento');
        $valor = $requisicao->input('valor');
        $descricao = $requisicao->input('descricao');
        $empresa = $requisicao->input('companie_id');
        $categoria = $requisicao->input('subcat_rec_id');
        $data_vencimento = $requisicao->input('data_vencimento');

        $this->validate($requisicao, $this->objRec->rules);

        //Converter na data formato bd EUA
//        $array_data = explode("/", $data_vencimento);
//        //dd($array_data);
//        $data_formato_bd = $array_data[2] . "-" . $array_data[1] . "-" . $array_data[0];
        //dd($data_formato_bd);

        $alterar = $this->objRec->find($id)->update([
            'nome_recebimento' => $nome_recebimento,
            'valor' => $valor,
            'status' => $status,
            'descricao' => $descricao,
            'companie_id' => $empresa,
            'subcat_rec_id' => $categoria,
            'data_vencimento' => $data_vencimento,
        ]);

        if ($alterar):

            return redirect()->route('recebimento.index')->with(['sucesso' => ' Recebimento alterado com sucesso!']);

        else:

            return redirect()->withErrors(['errors' => 'Näo possivel alterar!']);

        endif;
    }

    /*     * *******************************Métodos para Excluir********************************** */

    public function getExcluirTodasRec() {

        $title = 'Excluir todos os recebimentos';

        $obj_rec = DB::table('receipts')
                ->join('sub_cat_recebimentos', 'receipts.subcat_rec_id', '=', 'sub_cat_recebimentos.id')
                ->select('receipts.*', 'sub_cat_recebimentos.nome')
                ->OrderBy('receipts.data_vencimento')
                ->get();

        //quantidade de registros       
        $quant_receber = DB::table('receipts')
                ->select(DB::raw('count(*) as Quant_Recebimentos'))
                ->get();

        foreach ($quant_receber as $quant):
            $quant_rec = $quant->Quant_Recebimentos;
        endforeach;

        //quantidade de registros       
        $soma = DB::table('receipts')
                ->select(DB::raw('sum(valor) as SOMA_TOTAL'))
                ->get();

        foreach ($soma as $valor_soma):

            $soma_moeda_real = number_format($valor_soma->SOMA_TOTAL, 2, ',', '.');

        endforeach;

//         dd($soma_moeda_real);

        return view('recebimentos.excluir-todos-rec', compact('obj_rec', 'title', '$quant_receber', 'quant_rec', 'soma_moeda_real'));
    }

    //Exclui todos os registros
    public function DeleteTodasRec() {

        //dd('excluir');
        $deletar = DB::table('receipts')->delete();

        if ($deletar):

            return redirect()->route('recebimento.index')->with(['sucesso' => 'Todos Recebimentos excluidos com sucesso!']);

        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

    public function show($id) {

        //Procura pelo id dentro da tabela receips
        $obj_rec = $this->objRec->find($id);

        //dd($obj_rec);
        $title = "Excluir Recebimento {$obj_rec->nome_recebimento}";

        $data_carbon = $this->data_carbon;

        //Rota do formulário 
        return view('recebimentos.show', compact('title', 'obj_rec', 'data_carbon'));
    }

    public function destroy($id) {

        $deletar = $this->objRec->find($id)->delete();

        if ($deletar):

            return redirect()->route('recebimento.index')->with(['sucesso' => 'Recebimento excluido com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel excluir!']);

        endif;
    }

    //Somatorio de 30 dias 
    public function somaTrintaDias() {

        $soma = DB::table('receipts')
                ->select(DB::raw('sum(valor)as Total'))
                ->whereRaw('(MONTH(receipts.data_vencimento) = MONTH(CURDATE()))')
                ->get('valor');

        //Converter o array pelo valor float
        foreach ($soma as $valor):
            $soma_total = floatval($valor->Total);
        endforeach;

        return number_format($soma_total, 2, ',', '.');
    }

    //Soma de todos os recebimentos do banco de dados
    public function somaRecebimentos() {

        //Recuperando uma lista de valores de coluna
        $valor = $this->objRec->all()->pluck('valor');

        foreach ($valor as $valor_rec):
            $this->soma += floatval($valor_rec);

        endforeach;

        return number_format($this->soma, 2, ',', '.');
    }

    //Busca com nome da empresa
    public function empresaRecebimento($empresa) {

        $title = "Empresa: {$empresa}";
        $rec_empresa = DB::table('companies')
                ->join('receipts', 'companies.id', '=', 'receipts.companie_id')
                ->join('sub_cat_recebimentos', 'receipts.subcat_rec_id', '=', 'sub_cat_recebimentos.id')
                ->select('receipts.*', 'companies.nome_empresa', 'sub_cat_recebimentos.nome')
                ->where('companies.nome_empresa', 'LIKE', '%' . $empresa . '%')
                ->OrderBy('receipts.data_vencimento')
                ->paginate(5);

        return view('recebimentos.empresaRecebimento', compact('rec_empresa', 'title'));
    }

    /*     * ******************************Métodos para Parcelamento********************************** */

    public function receberParcelamento($id) {

        $obj_rec = $this->objRec->paginate($this->total_paginas);
        $title = 'Cadastrar parcelamento';

        $parcelamentos = ['Semanal', 'Quinzenal', 'Mensal', 'Anual'];
        //Companie::all()->find($id);
        $empresa = Companie::all()->find($id);

        $id_empresa = $empresa->id;
        //Instância da classe Clientes
        //$obj_cliente = DB::table('customers')->get(['id', 'nome_cliente']);
        //Instância da classe Categoria de recebimentos
        $obj_cat_rec = DB::table('sub_cat_recebimentos')->get(['id', 'nome']);


        //Rota do formulário
        return view('recebimentos.formCadParcelamentoRec', compact('obj_rec', 'obj_cat_rec', 'title', 'parcelamentos', 'id_empresa'));
    }

    public function postParcelamentoRec(Request $requisicao) {

        //dd($requisicao->all());
        //Validação dos campos de formulário
        $this->validate($requisicao, [
            'nome_recebimento' => 'required|max:50',
            'valor' => 'required',
            'status' => 'required',
            'quant_parcelas' => 'required',
            'nome_parcela' => 'required',
            'descricao' => 'max:100',
            'data_vencimento' => 'required',
            'subcat_rec_id' => 'required'
        ]);

        //Guarda os valores recuperados no formulário em cada variavel
        $nome_parcela = $requisicao->input('nome_parcela');
        $quant_parcela = $requisicao->input('quant_parcelas');
        $nome_recebimento = $requisicao->input('nome_recebimento');
        $status = $requisicao->input('status');
        $nota_fiscal_cr = $requisicao->input('nota_fiscal_cr');
        $valor = $requisicao->input('valor');
        $descricao = $requisicao->input('descricao');
        $empresa = $requisicao->input('companie_id');
        $categoria = $requisicao->input('subcat_rec_id');
        $data_vencimento = $requisicao->input('data_vencimento');

        //Converte para moeda no padrão mundial do Bd
        $obj_moeda_real = new MoedaMundialController();
        $valor_bd = $obj_moeda_real->formatoBd($valor);

        //Chamada função para opção de parcelamento
        $retorno_parcelas = $this->menuTipoParcelamento($data_vencimento, $nome_parcela, $quant_parcela);

        foreach ($retorno_parcelas as $key => $ret_data_vencimento):

            //converte data no padrão UTC-mundial
            $ret_data = $this->data_carbon->parse($ret_data_vencimento)->format('Y-m-d H:i:s');

            //Salva valores recuperados do formulário que usuário digitou
            $retorno_rec = $this->objRec->create([
                'data_vencimento' => $ret_data,
                'nome_recebimento' => $nome_recebimento,
                'nota_fiscal_cr' => $nota_fiscal_cr,
                'valor' => $valor_bd,
                'status' => $status,
                'quant_parcelas' => $quant_parcela,
                'descricao' => $descricao,
                'companie_id' => $empresa,
                'subcat_rec_id' => $categoria,
            ]);

            if ($retorno_rec):

                print_r("Salva com sucesso" . $retorno_rec);

            endif;

            $parcelamentos = new ParcelamentoRecebimento(); //Instância da model classe Parcelamento 
            //Recupera o id de cada recebimento gerado pelo sistema
            $parcelamentos->receipt_id = $retorno_rec->id;

            //Salva na tabela parcelamento
            $salva_parcelamento = $parcelamentos->create([
                'nome_parcela' => $nome_parcela,
                'quant_parcelas' => $quant_parcela,
                'receipt_id' => $parcelamentos->receipt_id
            ]);

        endforeach;
        if ($salva_parcelamento):
            return redirect()->route('recebimento.index')->with(['sucesso' => 'Parcelamento do Recebimento salva com sucesso!']);
        else:

            return redirect()->back()->withErrors(['errors' => 'Näo possivel salvar parcelamento']);

        endif;
    }

    public function menuTipoParcelamento($data_vencimento, $nome_parcela, $quant_parcela) {

        $dt = explode("/", $data_vencimento); //retira o espaço no meio quebra em um array
        //dd($dt);
        $ano = $dt[2];
        $mes = $dt[1];
        $dia = $dt[0];
        //'Semanal', 'Quinzenal', 'Mensal', 'Anual'
        //$carbon = $this->data_carbon;

        $this->objParcelas = new ParcelamentoController($ano, $mes, $dia, $quant_parcela);

        switch ($nome_parcela) {

            //dd($nome_parcela);
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
                echo "<script>alert('Escolha uma opção entre 1 à 8!');<script>";
        }
    }

    public function statusAtrasado($id) {

        $alterar = $this->objRec
                ->where('id', $id)
                ->update(['status' => '2']);
        return $alterar;
    }

}

//Recuperando dados da empresa
//        $empresa = DB::table('companies')->get(['id', 'nome_empresa']);
//
//        foreach ($empresa as $dados_empr):
//
//            $empresa_id = $dados_empr->id;
//            $nome_empresa = $dados_empr->nome_empresa;
//            //dd($empresa_id);
//
//        endforeach;