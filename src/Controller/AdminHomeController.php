<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\View\Render;

class AdminHomeController
{
    public function index()
    {
        // Alimentando os dados para a tabela de listagem
        // $dadosListagem = [];
        // $dadosListagem['colunas'] = [
        //     ['campo'=>'qtdclientes',   'class'=>'text-center align-middle'],
        //     ['campo'=>'qtdprodutos',   'class'=>'text-center align-middle'],
        //     ['campo'=>'qtdcategorias', 'class'=>'text-center align-middle'],
        //     ['campo'=>'qtdmarcas',     'class'=>'text-center align-middle'],
        // ];
        // $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Home';
        $dados['usuario'] = $_SESSION['usuario'];
        // $dados['tabela'] = $htmlTabela;

        // $sql = "SELECT count() AS qtdclientes,   count() AS qtdprodutos,
        //                count() AS qtdcategorias, count() AS qtdmarcas
        //         FROM produtos p
        //         INNER JOIN categorias ca ON p.idcategoria = ca.idcategoria
        //         INNER JOIN marcas m      ON p.idmarca     = m.idmarca
        //         INNER JOIN favoritos f   ON p.idproduto   = f.idproduto
        //         INNER JOIN clientes cl   ON f.idcliente   = cl.idcliente
        // ";
        // $dadosBuscados = DB::select($sql);

        Render::back('home', $dados);
    }
}