<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;

class Credito extends Model {

    //Utilizado para formulários
    use FormAccessible;

    protected $fillable = ['status', 'valor', 'nome_credito', 'data_recebimento', 'forma_pagamento_id', 'receipt_id', 'data_vencimento', 'bank_id'];

    //Formato de data padrão Brasileiro
    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    //Formato de data padrão Americano BD
    public function formDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
