<?php

/**
 * Função que retorna um ALERT da mensagem
 * presa na sessão e elimina o seu conteúdo
 *
 * @return void
 */
function retornaHTMLAlertMensagemSessao()
{

    if ( !isset($_SESSION['mensagem']) || !is_array($_SESSION['mensagem']) ) {
        return '';  
    }

    $tipo = $_SESSION['mensagem']['tipo'];
    $texto = $_SESSION['mensagem']['texto'];


    $bootstrapAlert = <<<HTML
        <div class="alert alert-{$tipo}" role="alert">
            {$texto}
        </div>
    HTML;

    // Elimina a variável da memória para ela não aparecer novamente depois
    unset( $_SESSION['mensagem'] );

    return $bootstrapAlert;
}

/**
 * Função que redireciona (via header location) para uma URL específica
 *
 * @param string $destino URL de destino
 * @param string $tipoMsg primary, secondary, success, danger, 
 *                         warning, info, light, dark
 * @param string $mensagem
 * @return void
 */
function redireciona(string $destino, string $tipoMsg = '', string $mensagem = '')
{
    if ($tipoMsg && $mensagem) {
        $_SESSION['mensagem'] = [
            'tipo'  => $tipoMsg,
            'texto' => $mensagem
        ];
    }
    header('location:' . $destino);
    exit;
}

/**
 * Verifica se o cliente está logado, se não estiver,
 * redireciona para a página de login e exibe uma mensagem
 *
 * @return void
 */
function acessoRestrito()
{
    if ( empty($_SESSION['cliente']) ) {
        redireciona('/login', 'danger', 'Faça logon para continuar');
    }
}