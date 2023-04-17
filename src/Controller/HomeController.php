<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\FrontController;
use CantinhoModa\Model\Produto;
use CantinhoModa\View\Render;

class HomeController extends FrontController
{
    public function index()
    {
        $dados = [];
        $dados['titulo'] = 'Home';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        
        $produto = new Produto();
        $rowsProdutos = $produto->find(['idmarca = ' => 1]);

        foreach ($rowsProdutos as &$p) {
            $produto->loadById($p['idproduto']);

            // $p['imagens'] = $produto->getFiles();
        }
        
        $dados['produtos'] = $rowsProdutos;
        
        Render::front('home', $dados);
    }
}