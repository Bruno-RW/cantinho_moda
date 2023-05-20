<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\Core\FrontController;
use CantinhoModa\Model\Produto;
use CantinhoModa\View\Render;

class CatalogoController extends FrontController
{
    public function catalogo()
    {
        $dados = [];
        $dados['titulo'] = 'Catálogo';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
                     
        $sql = 'SELECT p.idproduto, p.idmarca, p.idcategoria, p.nome, p.preco, p.tamanho, f.ativo, m.marca
                FROM produtos p
                INNER JOIN categorias c ON c.idcategoria = p.idcategoria
                INNER JOIN marcas m ON m.idmarca = p.idmarca
                LEFT JOIN favoritos f ON f.idproduto = p.idproduto
                            AND f.idcliente = ?';
        $parametros = [ $_SESSION['cliente']['idcliente'] ?? 0];
        $rowsProdutos = DB::select($sql, $parametros);

        $produto = new Produto();
        foreach ($rowsProdutos as &$p) {
            $produto->loadById($p['idproduto']);

            $p['imagens'] = $produto->getFiles();
            $p['desconto'] ??= 0.15;
            $p['precodesconto'] = $p['preco'] * (1 -  $p['desconto']);
        }
        
        $dados['produtos'] = $rowsProdutos;
        
        Render::front('catalogo', $dados);
    }
}