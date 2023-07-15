<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\Core\FrontController;
use CantinhoModa\Model\Categoria;
use CantinhoModa\Model\Marca;
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
        
        switch($_GET['filtro'] ?? 'De A a Z') {
            case 'De Z a A': 
                $orderBy = 'ORDER BY p.nome DESC, p.preco'; 
                break;
            case 'Maior preço': 
                $orderBy = 'ORDER BY p.preco DESC, p.nome'; 
                break;
            case 'Menor preço': 
                $orderBy = 'ORDER BY p.preco, p.nome'; 
                break;
            default:
                $orderBy = 'ORDER BY p.nome, p.preco';
        }

        $categoriasFiltradas = [];
        foreach($_GET['categoria']??[] as $val) {
            if ( is_numeric($val) ) {
                $categoriasFiltradas[] = (int) $val;
            }
        }

        $marcasFiltradas = [];
        foreach($_GET['marca']??[] as $val) {
            if ( is_numeric($val) ) {
                $marcasFiltradas[] = (int) $val;
            }
        }

        $where = '';
        if ($categoriasFiltradas || $marcasFiltradas) {
            if ($categoriasFiltradas) {
                $where = 'WHERE c.idcategoria IN ('.implode(',', $categoriasFiltradas).') ';
            }
            if ($marcasFiltradas) {
                if (!$where) {
                    $where = 'WHERE c.idcategoria IN ('.implode(',', $marcasFiltradas).') ';
                } else {
                    $where .= 'AND m.marca IN ('.implode(',', $marcasFiltradas).') ';
                }
            }
        }

        //p.preco between menorpreco and maiorpreco
        //if ($where)

        $sql = "SELECT p.idproduto, p.idmarca, p.idcategoria, p.nome, p.preco, p.tamanho, f.ativo, m.marca
                FROM produtos p
                INNER JOIN categorias c ON c.idcategoria = p.idcategoria
                INNER JOIN marcas m ON m.idmarca = p.idmarca
                LEFT JOIN favoritos f ON f.idproduto = p.idproduto
                            AND f.idcliente = ?
                {$where}
                {$orderBy}";
        $parametros = [ $_SESSION['cliente']['idcliente'] ?? 0];
        $rowsProdutos = DB::select($sql, $parametros);

        $produto = new Produto();
        foreach ($rowsProdutos as &$p) {
            $produto->loadById($p['idproduto']);

            $p['imagens'] = $produto->getFiles();
            $p['desconto'] ??= 0.15;
            $p['precodesconto'] = $p['preco'] * (1 -  $p['desconto']);
        }
        
        $categoria = new Categoria;
        $rowsCategorias = $categoria->find();
        foreach ($rowsCategorias as &$c) {
            $categoria->loadById($c['idcategoria']);
        }

        $marca = new Marca;
        $rowsMarcas = $marca->find();
        foreach ($rowsMarcas as &$m) {
            $marca->loadById($m['idmarca']);
        }

        $dados['produtos'] = $rowsProdutos;
        $dados['categorias'] = $rowsCategorias;
        $dados['marcas'] = $rowsMarcas;
        
        Render::front('catalogo', $dados);
    }
}