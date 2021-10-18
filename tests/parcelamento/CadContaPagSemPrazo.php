<?php
#Tela Principal do usuário Administrador

require_once('../Model/ClassEmpresas.php');
require_once('../Model/ClassContasPagar.php');
require_once('../Model/ClassClientes.php');
require_once('../Model/ClassCategoriaPagar.php');
require_once('../Model/ClassContasBancarias.php');
require_once('../Model/ClassBancos.php');
require_once('FormatoMoeda.php');
require_once('../libs/Carbon/vendor/autoload.php');

use Carbon\Carbon;

session_start();

if (!isset($_SESSION['usuario_session']) && !isset($_SESSION['senha_session'])) {

    echo "<meta http-equiv='refresh' content = '0, url=../index.php'>";
} else {
    ?>
    <!DOCTYPE HTML>
    <!--
           Eduardo Augusto - pagina CadastrarContaPagar
    -->
    <html>
        <head>
            <title>GST Empresarial</title>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
            <link rel="stylesheet" href="../assets/css/main.css" />
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />   
            <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
            <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->

            <?php

                $id_empresa = $_POST['id_empresa']; //Pega o id_empresa pelo input hidden
                
                $descricao = $_POST['descricao'];
                $id_banco = $_POST['id_banco'];
                $valor = $_POST['valor'];
                $data_vencimento = $_POST['data_venc']; //Data que do Vencimento 
                $status_pag = $_POST['status_pag']; //Status do pagamento: 1 - em aberto / 2 - pago / 3 - atraso                    
                $id_cliente = $_POST['id_cliente'];
                $id_cat_rec = $_POST['id_cat_rec'];
                $opcao_calendario = $_POST['opcao_calendario'];

                //Instânciando todas classes
                $ObjContRec = new ContasPagar();
                $Objcliente = new Clientes();
                $ObjEmp = new Empresas();
                $ObjCatRec = new CategoriaPagar();
                $ObjBanco = new Bancos(); //Banco de dinheiro
                $ObjContaBancaria = new ContasBancarias();
                $data_atual = Carbon::createFromDate();

                $Novo_valor = Moeda_mysql($valor); //Chama a função para converte o valor no formato do Real           

                //echo $data_atual;

                $ObjContRec->setDescricao($descricao);
                $ObjContRec->setValor($Novo_valor);
                $ObjContRec->setData_vencimento($data_vencimento);
                $ObjContRec->setStatus($status_pag);
                $ObjContRec->setCliente_id($id_cliente);
                $ObjContRec->setEmpresa_id($id_empresa);
                $ObjContRec->setCat_cont_receber_id($id_cat_rec);
                $ObjContRec->setData_alterecao($data_atual);
                $ObjContRec->setData_cadastro($data_atual);
                $ObjContRec->setBanco_id($id_banco);
                $ObjContRec->setOpcao_calendario($opcao_calendario);

#*****************************Atualiza o saldo bancário**********************************************                    
                //se banco já foi cadastrado:  Apenas atualiza o saldo bancário do recebimento
                $retorno_saldo = $ObjContaBancaria->findContaBancaria($id_banco); //retorna objeto saldo

                if ($retorno_saldo):

                    $saldo_atual = $retorno_saldo->saldo; //retorna o dado saldo
                    if ($saldo_atual):

                        $total_saldo = $ObjContaBancaria->SomarSaldoBancario($Novo_valor, $saldo_atual); //Metódo SomarSaldoBancario retorno novo saldo: saldo(novo valor + valor atual)
//                        echo "<pre>";
//                        print_r($total_saldo);
//                        echo "</pre>";
                        $retorno = $ObjContaBancaria->updateSaldo($id_banco, $total_saldo); //Atualiza novo valor de saldo

                    endif;

                //Se não: cadastra o banco com novo saldo do recebimento   
                else:

                    $ObjContaBancaria->setBanco_id($id_banco);
                    $ObjContaBancaria->SetEmpresa_id($id_empresa);
                    $ObjContaBancaria->setData_alterecao($data_atual);
                    $ObjContaBancaria->setData_cadastro($data_atual);
                    $ObjContaBancaria->setSaldo($saldo);
                    $ObjContaBancaria->insert(); //Cadastra nova conta bancária                          

                endif;
#***************************************************Cadastrar ContasPagar no BD**********************************************************

                if ($ObjContRec->insert()):
                    echo "<script>alert('Cadastro feito com sucesso!'); document.location='ContaPagarEmpresa.php?acao=financeiro&id=" . $id_empresa . "';</script>";
                    return true;
                else:
                    return false;

                endif;
         
            ?>

        </body>  
    </html>
    <?php
}