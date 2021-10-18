<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Authentication Defaults
      |--------------------------------------------------------------------------
      |
      | Esta opção controla a autenticação padrão "guard" e a senha
           | Opções de reinicialização para sua aplicação. Você pode alterar esses padrões
           | Como exigido, mas eles são um começo perfeito para a maioria das aplicações.
      |
     */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    /*
      |--------------------------------------------------------------------------
      | Protetores de Autenticação
           | ------------------------------------------------- -------------------------
           |
           | Em seguida, você pode definir cada guarda de autenticação para sua aplicação.
           | É claro que uma grande configuração padrão foi definida para você
           | Aqui que usa armazenamento de sessão eo provedor de usuário Eloquent.
           |
           | Todos os drivers de autenticação têm um provedor de usuário. Isso define como o
           | Os usuários são realmente recuperados de seu banco de dados ou outro armazenamento
           | Mecanismos utilizados por este aplicativo para persistir dados do usuário.
           |
           | Suportado: "sessão", "token"
      |
     */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],        
        //Guards o administrador    
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'admin-api' => [
            'driver' => 'token',
            'provider' => 'admins',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Providers de Usuário
           | ------------------------------------------------- -------------------------
           |
           | Todos os drivers de autenticação têm um Providers de usuário. Isso define como o
           | Os usuários são realmente recuperados de seu banco de dados ou outro armazenamento
           | Mecanismos utilizados por este aplicativo para persistir dados do usuário.
           |
           | Se você tiver várias tabelas ou modelos de usuários, poderá
           | Fontes que representam cada modelo / tabela. Essas fontes podem então
           | Ser atribuído a quaisquer proteções de autenticação adicionais definidas.
           |
           | Suportado: "banco de dados", "eloqüente"
      |
     */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,//De acordo com a model Admin
        ],
    // 'users' => [
    //     'driver' => 'database',
    //     'table' => 'users',
    // ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Como redefinir senhas
           | ------------------------------------------------- -------------------------
           |
           | Você pode especificar várias configurações de redefinição de senha se tiver mais
           | Uma tabela de usuário ou modelo na aplicação e você deseja ter
           | Configurações de redefinição de senha separadas com base nos tipos de usuários específicos.
           |
           | O tempo de expiração é o número de minutos que o token de redefinição deve ser
           | Considerado válido. Esse recurso de segurança mantém os tokens de
           | Eles têm menos tempo para ser adivinhado. Você pode alterar isso conforme necessário.
      |
     */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 30,
        ],
    ],
];
