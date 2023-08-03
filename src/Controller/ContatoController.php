<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Core\FrontController;
use CantinhoModa\Core\SendMail;
use CantinhoModa\View\Render;
use Respect\Validation\Validator as v;

class ContatoController extends FrontController
{
    public function contato()
    {
        $dados = [];
        $dados['titulo'] = 'Contato';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        $dados['formulario'] = $this->formcontato();

        Render::front('contato', $dados);
    }

    private function formContato()
    {
        $dados = [
            'class'=>'row g-2',
            'btn_div'=>'',
            'btn_class'=>'btn normal',
            'fields'=>[
                [
                    'type'=>'text',
                    'label_class'=>'',
                    'input_class'=>'',
                    'name'=>'nome',
                    'placeholder'=> 'Nome completo',
                    'required'=>true
                ],
                [
                    'type'=>'email',
                    'label_class'=>'',
                    'input_class'=>'',
                    'name'=>'email',
                    'placeholder'=> 'E-mail',
                    'required'=>true
                ],
                [
                    'type'=>'text',
                    'label_class'=>'',
                    'input_class'=>'',
                    'name'=>'assunto',
                    'placeholder'=>'Assunto',
                    'required'=>true
                ],
                [
                    'type'=>'textarea',
                    'label_class'=>'',
                    'input_class'=>'',
                    'name'=>'mensagem',
                    'placeholder'=>'Mensagem',
                    'rows'=>5,
                    'required'=>true
                ]
            ]
        ];
        return Render::block('form', $dados);
    }
}