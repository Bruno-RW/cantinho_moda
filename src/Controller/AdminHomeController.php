<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\View\Render;

class AdminHomeController
{
    public function index()
    {
        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Home';
        $dados['usuario'] = $_SESSION['usuario'];

        $dados['info']['categorias'] = $this->selectQtd('categorias');
        $dados['info']['clientes']   = $this->selectQtd('clientes');
        $dados['info']['produtos']   = $this->selectQtd('produtos');
        $dados['info']['marcas']     = $this->selectQtd('marcas');

        Render::back('home', $dados);
    }

    private function selectQtd(string $tabela): int
    {
        $sql = "SELECT count(0) AS total FROM {$tabela}";
        return DB::select($sql)[0]['total'];
    }
}