<?php

namespace CantinhoModa\Controller;

use CantinhoModa\View\Render;

class AdminLogController
{
    public function listar()
    {
        $dados = [];
        $dados['titulo'] = 'Log';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['log'] = '';

        Render::back('log', $dados);
    }
}