<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Core\FrontController;
use CantinhoModa\Model\Cliente;
use CantinhoModa\View\Render;

class CadastroController extends FrontController
{
    public function cadastro()
    {
        $dados = [];
        $dados['titulo'] = 'Cadastro';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        $dados['formCadastro'] = $this->formCadastro();

        Render::front('cadastro', $dados);
    }

    public function postCadastro()
    {
        try {
            $cliente = new Cliente();
            $cliente->nome    = $_POST['nome']    ?? null;
            $cliente->email   = $_POST['email']   ?? null;
            $cliente->senha   = $_POST['senha']   ?? null;
            if ($_POST['senha'] != $_POST['senha2']) {
                throw new Exception('O campo de senha e confirmação de senha devem ter o mesmo valor');
            }
            
            $resultado = $cliente->find(['email ='=>$cliente->email]);
            if ( !empty($resultado) ) {
                throw new Exception('Endereço de e-mail já cadastrado, selecione recuperar senha caso necessário');
            }
            $cliente->save();
        } catch (Exception $e) {
            $_SESSION['mensagem'] = [
                'tipo'  => 'warning',
                'texto' => $e->getMessage()
            ];
            $this->cadastro();
            exit;
        }
        
        redireciona('/login', 'info', 'Cadastro realizado com sucesso, faça login para continuar');
    }

    private function formCadastro()
    {
        $dados = [
            'class'=>'row',
            'btn_label'=>'Cadastrar',
            'btn_class'=>'btn',
            'fields'=>[
                [
                    'pre_html'=>'<i class="fa-solid fa-user"></i>',
                    'type'=>'text',
                    'name'=>'nome',
                    'label'=>'',
                    'label_class'=>'',
                    'input_class'=>'',
                    'placeholder'=>'Nome',
                    'class'=>'input-box',
                    'required'=>true
                ],
                [
                    'pre_html'=>'<i class="fa-solid fa-envelope"></i>',
                    'type'=>'email',
                    'name'=>'email',
                    'label'=>'',
                    'label_class'=>'',
                    'input_class'=>'',
                    'placeholder'=>'E-mail',
                    'class'=>'input-box',
                    'required'=>true
                ],
                [
                    'pre_html'=>'<i class="fa-solid fa-lock-open"></i>',
                    'type'=>'password',
                    'name'=>'senha',
                    'label_class'=>'',
                    'input_class'=>'',
                    'placeholder'=>'Senha',
                    'class'=>'input-box',
                    'required'=>true
                ],
                [
                    'pre_html'=>'<i class="fa-solid fa-lock"></i>',
                    'type'=>'password',
                    'name'=>'senha2',
                    'label_class'=>'',
                    'input_class'=>'',
                    'placeholder'=>'Confirme senha',
                    'class'=>'input-box',
                    'required'=>true
                ]
            ]
        ];
        return Render::block('form', $dados);
    }
}