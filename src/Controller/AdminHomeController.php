<?php

namespace CantinhoModa\Controller;

use CantinhoModa\View\Render;

class AdminHomeController
{
    public function index()
    {
        $dados = [];
        $dados['titulo'] = 'Home';
        $dados['usuario'] = $_SESSION['usuario'];

        Render::back('home', $dados);
    }
}