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
        $dados['cliente']['email'] = escondeCaracteres($_SESSION['cliente']['email']);

        $dtCadastro = strtotime($dados['cliente']['created_at']);
        $dados['cliente']['created_at'] = str_replace("-", "/", date("d-m-Y", $dtCadastro));
        
        Render::front('minha-conta', $dados);
    }
}