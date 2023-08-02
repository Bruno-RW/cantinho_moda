<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\FrontController;
use CantinhoModa\View\Render;

class CancelarJornalController extends FrontController
{
    public function cancelarJornal()
    {
        $dados = [];
        $dados['titulo'] = 'Cancelar Jornal';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();

        Render::front('cancelar-jornal', $dados);
    }

    public function postCancelarJornal()
    {

    }
}