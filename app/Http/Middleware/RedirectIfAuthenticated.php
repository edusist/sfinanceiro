<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {

    /**
     * Lidar com uma solicitação de entrada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    //Verifica se está autorizado 
    public function handle($request, Closure $next, $guard = null) {

//dd($request->path());
        switch ($guard) {
            case 'admin':

                if ($request->path() == "admin/logout"):

                    //Limpa a sessão
                    $request->session()->flush(); //echo "{$sessao }";
                    $request->session()->regenerate();
                    //Manda o usuário para tela inicial
                    return redirect()->route('admin.login');

                elseif ($request->path() == "admin/register"):                    
                    
                    dd(Auth::guard($guard)->check());
//                    $request->session()->flush();

                    //$request->session()->regenerate();
                    return redirect()->route('admin.register');


                //Verifica se usuário admin está realmente autênticado.
                elseif (Auth::guard($guard)->check()):
                    return redirect()->route('admin.painel');

                endif;

                break;
            default :
                
                //dd($guard);
                //guard web
                if (Auth::guard($guard)->check()):

                    return redirect('home');
                endif;
                break;
        }
        //dd($next($request));
        return $next($request);
    }

}
