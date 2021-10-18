<?php

require_once('../libs/Carbon/vendor/autoload.php');

use Carbon\Carbon;

Class DataCalendario extends Carbon {

    protected $ano = Null;
    protected $mes = Null;
    protected $dia = Null;
    protected $Quant_parc = Null;

    function __construct($ano, $mes, $dia, $Quant_parc) {
        $this->ano = $ano;
        $this->mes = $mes;
        $this->dia = $dia;
        $this->Quant_parc = $Quant_parc;
    }

    public function parcelaDiariamente() {

        $vet = array();

        for ($diaria = 0; $diaria < $this->Quant_parc; $diaria++):

            $data_dia = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addDay($diaria);

            array_push($vet, $data_dia);

        endfor;
        return $vet;
    }

    public function parcelaSemanal() {

        $vet = array();
        for ($semanal = 0; $semanal < $this->Quant_parc; $semanal++):

            $data_semanal = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addWeek($semanal);

            array_push($vet, $data_semanal);
        endfor;

        return $vet;
    }

    public function parcelaQuinzenal() {

        $vet = array();

        $quant_parc = $this->Quant_parc * 15; //Calculando a quinzena e quantidade de Quant_parc x 15

        $quinzenal = 0;

        while ($quinzenal < $quant_parc):

            $data_quinzenal = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addDay($quinzenal);

            $quinzenal+=15;

            array_push($vet, $data_quinzenal);
        endwhile;

        return $vet;
    }

    public function parcelaMensal() {

        $vet = array();

        for ($mensal = 0; $mensal < $this->Quant_parc; $mensal++):
            $data_Mensal = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addMonth($mensal);

            array_push($vet, $data_Mensal);
        endfor;

        return $vet;
    }

    public function parcelaBimestral() {

        $vet = array();

        $quant_parc = $this->Quant_parc * 2;

        $bimestral = 0;

        while ($bimestral < $quant_parc):

            $data_Bimestral = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addMonth($bimestral);

            $bimestral+=2;

            array_push($vet, $data_Bimestral);
        endwhile;

        return $vet;
    }

    public function parcelaTrimestral() {

        $vet = array();

        $quant_parc = $this->Quant_parc * 3;


        $trimestral = 0;
        while ($trimestral < $quant_parc):

            $data_trimestral = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addMonth($trimestral);

            $trimestral+=3;

            array_push($vet, $data_trimestral);
        endwhile;

        return $vet;
    }

    public function parcelaSemestral() {

        $vet = array();

        $quant_parc = $this->Quant_parc * 6;

        $semestre = 0;
        while ($semestre < $quant_parc):

            $data_semestral = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addMonth($semestre);
            $semestre+=6;
            array_push($vet, $data_semestral);

        endwhile;

        return $vet;
    }

    public function parcelaAnual() {

        $vet = array();

        for ($anual = 0; $anual < $this->Quant_parc; $anual++):

            $data_anual = Carbon::createFromDate($this->ano, $this->mes, $this->dia)->addYear($anual);

            array_push($vet, $data_anual);
        endfor;

        return $vet;
    }

}

$ObjData = new DataCalendario(2015, 12, 01, 3);
echo "<pre>";
    print_r($ObjData->parcelaDiariamente());
echo "</pre>";


