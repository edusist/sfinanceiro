<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel; //planilhas export e import
use Illuminate\Support\Facades\DB;
use App\models\Receipt;
use App\models\Pagamento;
use App\Http\Controllers\sistema\receiptsController;
use App\Http\Controllers\sistema\PagamentoController;
use Carbon\Carbon;

class ExcelController extends Controller {

    protected $obj_excel;
    protected $obj_rec;
    protected $carbon;

    public function __construct(Excel $excel, receiptsController $recebimento, Carbon $carbon, PagamentoController $pagamento) {

        $this->middleware('auth:admin');
        $this->obj_excel = $excel;
        $this->obj_rec = $recebimento;
        $this->obj_pag = $pagamento;
        $this->carbon = $carbon;
    }

    /*     * **********************************Gráficos de pagamento********************************** */

    //Chama da view do formulário para anexar o arquivo Excel
    public function getImportar() {

        return view('excel.importarRecebimentos');
    }

    //Importação de Excel
    public function postImportar() {

        $this->obj_excel->load('C:\xampp\htdocs\sistemaLaravel\resources\views\excel\receipts.csv', function($reader) {

            foreach ($reader->get() as $recebi):

                $item = explode(";", $recebi);

                $dados_excel = [
                    'nome_recebimento' => str_replace('{"nome_recebimentovalorstatusdescricao_data_vencimento_created_atupdated_at_companie_id_subcat_rec_idnota_fiscal_cr":"', '', $item[0]),
                    'valor' => floatval($item[1]),
                    'status' => $item[2],
                    'descricao' => $item[3],
                    'data_vencimento' => $this->carbon->parse(str_replace('\/', '-', $item[4]))->format('Y-m-d H:i:s'),
                    'created_at' => $this->carbon->parse(str_replace('\/', '-', $item[5]))->format('Y-m-d H:i:s'),
                    'updated_at' => $this->carbon->parse(str_replace('\/', '-', $item[6]))->format('Y-m-d H:i:s'),
                    'companie_id' => intval($item[7]),
                    'customer_id' => intval($item[8]),
                    'category_receipt_id' => intval($item[9]),
                    'nota_fiscal_cr' => str_replace('"}', '', $item[10])
                ];

                $cadastrar = Receipt::create($dados_excel);

            endforeach;

            if ($cadastrar):
                return redirect()->route('recebimento.index')->with(['sucesso' => 'Importação feita com sucesso!']);
            else:
                return redirect()->back()->withErrors(['errors' => 'Erro na importação!']);
            endif;
        });
    }

    /**
     * Código de exportação do arquivo
     *
     * @var array
     */
    public function getExportar() {

        $Recebis = DB::table('companies')
                        ->join('receipts', 'companies.id', '=', 'receipts.companie_id')
                        ->join('sub_cat_recebimentos', 'receipts.subcat_rec_id', '=', 'sub_cat_recebimentos.id')
                        ->select('receipts.id', 'receipts.nome_recebimento', 'receipts.data_vencimento', 'receipts.nota_fiscal_cr', 'receipts.valor', 'sub_cat_recebimentos.nome', 'companies.nome_empresa')
                        ->get()->toArray();
        //dd($Recebis);
        foreach ($Recebis as $rec):

            $Array_rec[] = $rec;

        endforeach;

        //converte em Json e depois converte em array
        $recebimento = json_decode(json_encode($Array_rec), true);

        $this->obj_excel->create('contas_receber', function($excel) use($recebimento) {

            // Set the title
            $excel->setTitle('Planilha de Contas à receber');

            // Chain the setters
            $excel->setCreator('Eduardo')->setCompany('Axia Contabilidade');

            $excel->setDescription('Demonstrativo de contas á receber');

            $excel->sheet('Recebimentos', function($sheet) use($recebimento) {

                //$sheet->setOrientation('landscape');
                $sheet->fromArray($recebimento);
            });
        })->download('xlsx');
    }

    public function graficoRecebimento() {

        $tres_mes_atras = $this->carbon->subMonth(3)->format('Y-m-d'); //mês atual
        $ano_atual = $this->carbon->now()->year; //ano atual
        //dd($tres_mes_atras);
        //Lista dos recebimento com data vencimento do mês atual
        $rec = DB::select("
                            SELECT SUM(r.valor) as total_rec, scr.nome FROM receipts r
                                INNER JOIN sub_cat_recebimentos scr 
                                ON(r.subcat_rec_id = scr.id)
                                where (YEAR(data_vencimento) = YEAR(CURDATE())) 
                                and (MONTH (data_vencimento) = MONTH (CURDATE()))
                                GROUP BY scr.nome  
                                ORDER BY scr.nome 
                          ");


        //dd($rec);

        $quant_rec = count($rec);

        if ($quant_rec == 0):

            return redirect()->route('recebimento.index')->withErrors(['errors' => 'Não existe recebimento para gráfico!']);
        else:

            foreach ($rec as $valor):

                //valor do recebimento            
                $array_rec[] = $valor; //Converte uma string e inteiro
                //$arr_dia[] = $this->carbon->parse($valor->data_vencimento)->format('d'); //dia do vencimento

            endforeach;

            return view('excel.graficoRecebimento', compact('array_rec'));
        endif; //Fim do if
    }

    public function getGrafico() {

        $rec = DB::select(" 
                        select scr.nome
                            from receipts r
                            inner join sub_cat_recebimentos scr
                            on scr.id = r.subcat_rec_id                            
                            GROUP BY scr.nome"
        );

        $resposta = response($rec->toArray());


        return $resposta;
    }

    //Exportar Pagamento
    public function exportarPagamento() {

        $pagar = DB::table('companies')
                        ->join('pagamentos', 'companies.id', '=', 'pagamentos.companie_id')
                        ->join('sub_cat_pagamentos', 'pagamentos.subcat_pag_id', '=', 'sub_cat_pagamentos.id')
                        ->select('pagamentos.id', 'pagamentos.nome_pagamento', 'pagamentos.data_vencimento', 'pagamentos.nota_fiscal_cp', 'pagamentos.valor', 'sub_cat_pagamentos.nome', 'companies.nome_empresa')
                        ->get()->toArray();

        foreach ($pagar as $pag):

            $Array_pag[] = $pag;

        endforeach;

        //converte em Json e depois converte em array
        $pagamento = json_decode(json_encode($Array_pag), true);

        $this->obj_excel->create('contas_pagar', function($excel) use($pagamento) {

            // Set the title
            $excel->setTitle('Planilha de Contas à pagar');

            // Chain the setters
            $excel->setCreator('Eduardo')->setCompany('Axia Contabilidade');

            $excel->setDescription('Demonstrativo de contas á pagar');

            $excel->sheet('Pagamentos', function($sheet) use($pagamento) {

                //$sheet->setOrientation('landscape');
                $sheet->fromArray($pagamento);
            });
        })->download('xlsx');
    }

    /*     * **********************************Gráficos de pagamento********************************** */

    public function graficoPagamento() {

        $mes_atual = $this->carbon->now()->month; //mês atual
        $ano_atual = $this->carbon->now()->year; //ano atual
        //Lista dos recebimento com data vencimento do mês atual

        $pag = DB::select("select scp.nome, pg.valor, pg.data_vencimento from pagamentos pg
                            inner join sub_cat_pagamentos scp
                            on pg.subcat_pag_id = scp.id
                            where MONTH(data_vencimento) = $mes_atual
                            and year(data_vencimento) = $ano_atual order by data_vencimento"
        );
        //Verifica se existe registros de recebimentos
        $quant_pag = count($pag);

        if ($quant_pag == 0):

            return redirect()->route('pagamento.index')->withErrors(['errors' => 'Não existe pagamentos para gráfico!']);

        else:

            foreach ($pag as $valor):

                //valor do recebimento
                $Array_pag[] = intval($valor->valor); //Converte uma string e inteiro
                $array_categoria[] = $valor->nome;
                $arr_dia[] = $this->carbon->parse($valor->data_vencimento)->format('d'); //dia do vencimento

            endforeach;

            return view('excel.graficoPagamento', compact('Array_pag', 'arr_dia', 'array_categoria'));

        endif; //fim do if
    }

    public function getGraficoPagamento() {

        $pag = Pagamento::all('valor');

        return response()->json($pag->toArray());
    }

}

//                    echo "<pre>";
//                    print_r($varNome);                   
//                    echo "</pre>";
//                    echo "<br />";
