<?php

namespace App\Http\Controllers\sistema;
use App\Http\Controllers\Controller;


class MoedaMundialController extends Controller {

 
    public function __construct() {

        $this->middleware('auth:admin');
    }

    public function formatoBd($valor) {

        $source = array('.', ',');
        $replace = array('', '.');
        $valor_bd = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto

        return $valor_bd; //retorna o valor formatado para gravar no banco
    }

}

