<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

class TrimStrings extends BaseTrimmer
{
    /**
     * Os nomes dos atributos que não devem ser aparados.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
