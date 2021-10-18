<?php

//Rotas
Route::get('/', function () {
    return view('index');
})->name('tela.login');



Route::get('/home', 'HomeController@index'); //Apenas Usuários(User) comuns autênticados tem acesso a está página 

Auth::routes();
Route::group(['middleware' => ['admin']], function() {   
      
     /***********************************Rotas de Autênticação do Admin************************************************************/
    Route::get('/admin', 'AdminController@saldo')->name('admin.painel'); //Apenas Administradores(Admin) autênticados tem acesso a está página 
    Route::get('/admin/login', 'adminAuth\AdminLoginController@showLoginForm')->name('admin.login'); //admin/
    Route::post('/admin/login', 'adminAuth\AdminLoginController@login')->name('admin.login.submit'); //admin/login foi sustituido pelo atual
    Route::get('/admin/logout', 'adminAuth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/admin/register', 'adminAuth\RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/admin/register', 'adminAuth\RegisterController@register')->name('admin.register');
    Route::post('/admin/password/email', 'adminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.email');
    Route::get('/admin/password/reset', 'adminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.request');
    Route::post('/admin/password/reset', 'adminAuth\ResetPasswordController@reset')->name('admin.reset');
    Route::get('/admin/password/reset/{token}', 'adminAuth\ResetPasswordController@showResetForm');    

    /************************************Rotas de Recebimento*********************************************************************/
    Route::resource('/admin/recebimento', 'sistema\receiptsController');
    Route::get('/admin/receber-pdf', 'sistema\receiptsController@pdf')->name('receber.pdf');
    
    //Dar baixa receber
    Route::get('/admin/lista-creditos', 'sistema\CreditoController@listaCreditos')->name('listaCreditos');
    Route::get('/admin/recebido/{id}', 'sistema\CreditoController@recebido')->name('recebido');
    Route::post('/admin/recebido', 'sistema\CreditoController@postRecebido')->name('postRecebido');
    //Forma de recebimento dinheiro ou banco
    Route::get('/admin/filtro-forma-recebimento', 'sistema\CreditoController@filtroFormaRecebimento')->name('filtroFormaRecebimento');
    
    //parcelamento conta á receber
    Route::get('/admin/parcelas', 'sistema\ParcelamentoController@index');
    Route::get('/admin/formCadParcelamentoRec/{id}', 'sistema\receiptsController@receberParcelamento')->name('formCadParcelamentoRec');
    Route::post('/admin/postParcelamentoRec', 'sistema\receiptsController@postParcelamentoRec')->name('postParcelamentoRec');
    //Pesquisar contas á receber
    Route::get('/admin/pesquisar', 'sistema\receiptsController@pesquisar')->name('pesquisar');
    Route::get('/admin/informacaoPesquisaReceber', 'sistema\receiptsController@informacaoPesquisaRec')->name('informacaoPesquisaReceber');
    //Filtrar por período
    Route::get('/admin/filtro-por-periodo/{id}', 'sistema\receiptsController@filtroPorPeriodo')->name('filtroPorPeriodo');
    
    //Excluir tudo
    Route::get('/admin/excluir-todas-rec', 'sistema\receiptsController@getExcluirTodasRec')->name('getExcluirTodasRec');
    Route::delete('/admin/excluir-todas-rec', 'sistema\receiptsController@DeleteTodasRec')->name('DeleteTodasRec');
 
   
    //Pesquisa por data Recebimento
    Route::get('/admin/pesquisar-data-receber', 'sistema\receiptsController@pesquisarDataReceber')->name('pesquisarDataReceber');
    Route::post('/admin/pesquisar-data-receber', 'sistema\receiptsController@postPesquisarDataReceber')->name('postPesquisarDataReceber');
    
    //Importar e exportar Excel Recebimento
    Route::get('/admin/getImportar', 'ExcelController@getImportar')->name('getImportar');
    Route::post('/admin/postImportar', 'ExcelController@postImportar')->name('postImportar');
    Route::get('/admin/getExportar', 'ExcelController@getExportar')->name('getExportar');
    
    //Gráfico Recebimento
    Route::get('/admin/grafico-recebimento', 'ExcelController@graficoRecebimento')->name('graficoRecebimento');
    Route::get('/admin/getGrafico', 'ExcelController@getGrafico')->name('getGrafico');
    Route::get('/admin/empresaRecebimento/{empresa}', 'sistema\receiptsController@empresaRecebimento')->name('empresaRecebimento');
    
    //Rotas do Categoria_Recebimento
    Route::resource('/admin/categoria_recebimento', 'sistema\CategoryReceiptController');
    //Rota da Sub Categoria recebimento
    Route::resource('admin/sub_categoria_recebimento', 'sistema\SubCatRecebimentoController');
    
    /**********************************Rotas do cliente***********************************************************************/
    Route::resource('/admin/cliente', 'sistema\CustomerController');
    Route::get('/admin/pdf', 'sistema\CustomerController@pdf')->name('pdf');
    /*************************************************************************************************************************/
    

    /************************************Rotas de pagamento ********************************************************************/
    Route::resource('/admin/pagamento', 'sistema\PagamentoController');
    Route::get('/admin/pagar-pdf', 'sistema\PagamentoController@pdf')->name('pagar.pdf');    
    
    
    //Dar baixa pago      
    Route::get('/admin/lista-debitos', 'sistema\DebitoController@listaDebitos')->name('listaDebitos');
    Route::get('/admin/pago/{id}', 'sistema\DebitoController@pago')->name('pago');
    Route::post('/admin/pago', 'sistema\DebitoController@postPago')->name('postPago');
    //Forma de recebimento dinheiro ou banco
    Route::get('/admin/filtro-forma-pagamento', 'sistema\DebitoController@filtroFormaPagamento')->name('filtroFormaPagamento');
    
  
    //parcelamento conta á pagar
    Route::get('/admin/formCadParcelamentoPag/{id}', 'sistema\PagamentoController@pagarParcelamento')->name('formCadParcelamentoPag');
    Route::post('/admin/postParcelamentoPag', 'sistema\PagamentoController@postParcelamentoPag')->name('postParcelamentoPag');
    //Pesquisar conta á pagar
    Route::get('/admin/pesquisar', 'sistema\PagamentoController@pesquisar')->name('pesquisar');
    Route::get('/admin/informacaoPesquisa', 'sistema\PagamentoController@informacaoPesquisa')->name('informacaoPesquisa');
    //Pesquisa por data Pagamento
    Route::get('/admin/pesquisar-por-data', 'sistema\PagamentoController@pesquisarPorData')->name('pesquisarPorData');
    Route::post('/admin/pesquisar-por-data', 'sistema\PagamentoController@postPesquisarPorData')->name('postPesquisarPorData');
    
    //Filtrar por período
    Route::get('/admin/filtroPorPeriodoPagar/{id}', 'sistema\PagamentoController@filtroPorPeriodoPagar')->name('filtroPorPeriodoPagar');
    Route::get('/admin/excluir-todas-pag', 'sistema\PagamentoController@getExcluirTodasPag')->name('getExcluirTodasPag');
    Route::delete('/admin/excluir-todas-pag', 'sistema\PagamentoController@DeleteTodasPag')->name('DeleteTodasPag');
    
    //Rotas Excel pagamentos
    Route::get('/admin/exportar-Pagamento', 'ExcelController@exportarPagamento')->name('exportarPagamento');
    
    //Gráfico pagamentos
    Route::get('/admin/grafico-pagamento', 'ExcelController@graficoPagamento')->name('graficoPagamento');
    Route::get('/admin/getGrafico-Pagamento', 'ExcelController@getGraficoPagamento')->name('getGraficoPagamento');
    
    //Rotas do Categoria_pagamento
    Route::resource('/admin/categoria_pagamento', 'sistema\CategoryPaymentController');
    //Rotas da Sub Categoria pagamento
    Route::resource('admin/sub_categoria_pagamento', 'sistema\SubCatPagamentoController');
    /*******************************************************************************************************************/
    
    
    
    
    /************************************Rotas do Usuário*****************************************************************/
    Route::resource('/admin/usuarios', 'sistema\UserController');
    
    //Rotas do sistema
    Route::get('/admin/cadastroform', 'sistema\UserController@cadastroform');
    Route::get('/admin/official', 'sistema\UserController@relacionatblUserOfficial');
    /***********************************Rotas do fornecedor***************************************************************/
    Route::resource('/admin/fornecedor', 'sistema\ProviderController');
    /***********************************Rotas do empresa*******************************************************************/
    Route::resource('/admin/empresa', 'sistema\CompanieController');
    /***********************************Rotas do banco***********************************************************************/
    Route::resource('/admin/banco', 'sistema\BankController');
    //Rotas do Empresa_banco controller
    Route::resource('/admin/empresa_banco_ctrl', 'sistema\CompanieBankController');
    
    //Forma de pagamento
    Route::resource('/admin/forma-pagamento', 'sistema\FormaPagamentosController');
});
