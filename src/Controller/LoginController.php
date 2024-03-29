<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Core\FrontController;
use CantinhoModa\Model\Cliente;
use CantinhoModa\View\Render;

class LoginController extends FrontController
{
    public function login()
    {
        if ( !empty($_SESSION['cliente']) ) {
            redireciona('/');
        }

        $dados = [];
        $dados['titulo'] = 'Login';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        $dados['formLogin'] = $this->formLogin();

        Render::front('login', $dados);
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        session_start();
        redireciona('/login', 'info', 'Desconectado com sucesso');   
    }

    public function postLogin()
    {
        try {
            if ( empty($_POST['email'] || empty($_POST['senha'])) ) {
                throw new Exception('Os campos de usuário e senha devem ser informados');
            }
    
            if (strlen($_POST['senha']) < 5) {
                throw new Exception('O comprimento da senha é inválido, digite ao menos cinco caracteres');
            }
            
            $dadosUsuario = ( new Cliente )->find([ 'email ='=>$_POST['email'] ]);
    
            if ( !count($dadosUsuario) ) {
                throw new Exception('Usuário ou senha inválidos');
            }
            
            $hashDaSenha = hash_hmac('md5', $_POST['senha'], SALT_SENHA);
            $senhaNoBanco = $dadosUsuario[0]['senha'];
    
            $senhaValida = password_verify($hashDaSenha, $senhaNoBanco);
    
            if (!$senhaValida) {
                throw new Exception('Usuário ou senha inválidos');
            }
    
            $_SESSION['cliente'] = $dadosUsuario[0];
            $nome =  $_SESSION['cliente']['nome'];
            $_SESSION['cliente']['prinome'] = substr($nome , 0, strpos($nome, ' '));
    
            redireciona('/');
        } catch(Exception $e) {
            $_SESSION['mensagem'] = [
                'tipo'  => 'warning',
                'texto' => $e->getMessage()
            ];
            $_POST['senha'] = '';
            $this->login();
        }
    }

    private function formLogin()
    {
        $dados = [
            'class'=>'row',
            'btn_label'=>'Entrar',
            'btn_class'=>'btn',
            'fields'=>[
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
                    'pre_html'=>'<i class="fa-solid fa-lock"></i>',
                    'type'=>'password',
                    'name'=>'senha',
                    'label_class'=>'',
                    'input_class'=>'',
                    'placeholder'=>'Senha',
                    'class'=>'input-box',
                    'required'=>true
                ]
            ]
        ];
        return Render::block('form', $dados);
    }
}