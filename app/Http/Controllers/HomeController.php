<?php

namespace App\Http\Controllers;

use App\Http\Controllers\sistema\receiptsController;
use App\models\Pagamento;

class HomeController extends Controller {

    protected $obj_rec;
    protected $obj_pag;

    public function __construct(receiptsController $recebimento, Pagamento $pagamento) {

        $this->middleware('auth');
        $this->obj_rec = $recebimento;
        $this->obj_pag = $pagamento;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

           //Obtem o valor do recebimento para substrair
        $recebimento = $this->obj_rec->somaRecebimentos();
        $resultado_rec = str_replace(".", "", $recebimento); // retirar o ponto
        $resultado_rec = str_replace(",", ".", $resultado_rec); // substituir ',' por '.'
        
        //Obtem o valor do pagamento para ser subtraido
        $pagamento = $this->obj_pag->somaPagamento();
        $resultado_pag = str_replace(".", "", $pagamento); // retirar o ponto
        $resultado_pag = str_replace(",", ".", $resultado_pag); // substituir ',' por '.'

        //Converte de string para float
        $resultado = floatval($resultado_rec) - floatval($resultado_pag);
        $fluxo_caixa = number_format($resultado, 2, ',', '.');
        
        return view('home', compact('recebimento', 'pagamento', 'fluxo_caixa'));
    }

}
