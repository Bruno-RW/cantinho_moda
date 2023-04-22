<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\FrontController;
use CantinhoModa\Model\Empresa;
use CantinhoModa\View\Render;

class SobreController extends FrontController
{
    public function sobre()
    {
        $dados = [];
        $dados['titulo'] = 'Sobre';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();

        $empresa = new Empresa();
        $rowsEmpresa = $empresa->find();

        foreach ($rowsEmpresa as &$e) {
            $empresa->loadById($e['idempresa']);
            $e['imagens'] = $empresa->getFiles();
        }
        
        $dados['empresa'] = $rowsEmpresa;

        Render::front('sobre', $dados);
    }
}