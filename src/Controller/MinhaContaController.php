<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\FrontController;
use CantinhoModa\View\Render;

class MinhaContaController extends FrontController
{
    public function minhaConta()
    {
        acessoRestrito();
        
        $dados = [];
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        
        $dados['cliente'] = $_SESSION['cliente'];
        $dados['cliente']['email'] = $this->escondeCaracteres($_SESSION['cliente']['email']);

        $dtCadastro = strtotime($dados['cliente']['created_at']);
        $dados['cliente']['created_at'] = str_replace("-", "/", date("d-m-Y", $dtCadastro));
        
        Render::front('minha-conta', $dados);
    }

    /**
     * Método para esconder caractéres de um e-mail
     *
     * @param string $email
     * @return mixed
    */
    public function escondeCaracteres (string $email) : string {

            $posArroba = strpos($email, "@");
    
            $texto = substr($email, 1, $posArroba-2);
            $tamanhoTexto = strlen($texto);
    
            $email = str_replace($texto, str_repeat("*", $tamanhoTexto), $email);

        return $email;
      }
}