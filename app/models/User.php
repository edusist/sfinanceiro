<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

class User extends Model {

    use FormAccessible;

//lista branca - Quais campos podem ser preenchidos
    protected $fillable = ['nome', 'sobrenome', 'email', 'senha', 'official_id'];
// protected $guarded = ['admin'];//lista negra
//Regras de validação
    public $rules = [

        'nome' => 'required|min:3|max:100',
        'sobrenome' => 'required|min:3|max:100',
        'email' => 'required',
        'official_id' => 'required',
        'senha' => 'required|min:3|max:100', //Somente teste. maximo deve ser max:8
    ];

    /**
     * Get the user’s date of birth.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y H:m:s');
    }

    /**
     * Get the user's date of birth for forms.
     *
     * @param  string  $value
     * @return string
     */
    public function formDateOfBirthAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function formatoBrasil($data) {

        foreach ($data as $valor):
            echo "<pre>";
            return $this->getDateOfBirthAttribute($valor->created_at);
//return 
            echo "</pre>";
        endforeach;
    }

}
