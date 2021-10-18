<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable {
    /* Notifiable -> Além do suporte para o envio de e-mails , a Laravel oferece suporte para 
     * o envio de notificações através de uma variedade de canais de entrega, 
     * incluindo correio, SMS (via Nexmo ) e Slack . As notificações também podem
     *  ser armazenadas em um banco de dados para que elas possam ser exibidas em 
     * sua interface web.
     */

use Notifiable;

    //guard=admin precisa ser igual ao guard do arquivo auth.php 
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new AdminResetPasswordNotification($token));
    }

}
