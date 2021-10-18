<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;

class Debito extends Model {

    //Utilizado para formulários
    use FormAccessible;

    protected $fillable = [
                           'valor', 
                           'nome_debito',
                           'data_pagamento', 
                           'forma_pagamento_id', 
                           'pagamento_id',
                           'data_vencimento',
                           'bank_id',
                           'created_at',
                           'updated_at'
                          ];

    //Formato de data padrão Brasileiro
    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    //Formato de data padrão Americano BD
    public function formDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
