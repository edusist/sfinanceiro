<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ParcelamentoPagamento extends Model
{
    protected $fillable = ['nome_parcela', 'quant_parcelas', 'codigo_parcela', 'pagamento_id'];
}
