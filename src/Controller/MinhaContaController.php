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

        Render::front('minha-conta', $dados);
    }
}