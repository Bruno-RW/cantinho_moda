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
        $dados['titulo'] = 'Minha Conta';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        
        $dados['cliente'] = $_SESSION['cliente'];
        $dados['cliente']['email'] = escondeEmail($dados['cliente']['email']);

        $dtCadastro = strtotime($dados['cliente']['created_at']);
        $dados['cliente']['created_at'] = str_replace("-", "/", date("d-m-Y", $dtCadastro));

        $dados['formEmail'] = $this->formAlteraEmail();
        
        Render::front('minha-conta', $dados);
    }

    private function formAlteraEmail()
    {
        $dados = [
            'class'=>'form form-email row g-2',
            'btn_div'=>'text-center',
            'btn_label'=>'Alterar',
            'btn_class'=>'btn normal',
            'fields'=>[
                [
                    'pre_html'=>'<i class="fa-solid fa-envelope"></i>',
                    'type'=>'email',
                    'label_class'=>'',
                    'input_class'=>'',
                    'name'=>'email',
                    'placeholder'=> 'E-mail atual',
                    'class'=>'input-box',
                    'required'=>true
                ],
                [
                    'pre_html'=>'<i class="fa-solid fa-envelope"></i>',
                    'type'=>'email',
                    'label'=>'Novo e-mail',
                    'label_class'=>'',
                    'input_class'=>'',
                    'name'=>'email2',
                    'placeholder'=> 'Novo e-mail',
                    'class'=>'input-box',
                    'required'=>true
                ]
            ]
        ];
        return Render::block('form', $dados);
    }
}