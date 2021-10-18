<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cliente extends Model {

    protected $dates = ['updated_at'];    
    protected $dateFormat = 'U';

    //Formato de data padrão Brasileiro
    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    //Formato de data padrão Americano BD
    public function formDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
