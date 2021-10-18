<?php
   function umParaMuitos() {

        $dataForm = [
            'nome_recebimento' => 'recibo 2',
            'nota_fiscal_cr' => '21213',
            'valor' => '1200',
            'status' => '1',
            'descricao' => 'bla',
            'data_vencimento' => '2017-02-17 17:10:21',
            'companie_id' => '1',
            'customer_id' => '1',
            'category_receipt_id' => '5',
            'nome_parcela' => 'mensal',
            'quant_parcelas' => '3',
            'codigo_parcela' => '4'
        ];

        $receber = $this->objRec->create($dataForm);
        //dd($receber);
        $dataForm['receipt_id'] = $receber->id;
        //dd($dataForm);
        $parcelamento = Parcelamento::create($dataForm);

        if ($parcelamento):
            echo 'true';
        else:
            echo 'false';
        endif;
    }

