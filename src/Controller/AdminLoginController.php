<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Model\Usuario;
use CantinhoModa\View\Render;

class AdminLoginController
{
    public function login()
    {
        if ( !empty($_SESSION['usuario']) ) {
            redireciona('/admin/home');
        }

        $dados = [];
        $dados['titulo'] = 'Login | Admin';
        $dados['formLogin'] = $this->formLogin();

        Render::front('admin-login', $dados);
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
            
            $dadosUsuario = ( new Usuario )->find([ 'email ='=>$_POST['email'] ]);
    
            if ( !count($dadosUsuario) ) {
                throw new Exception('Usuário ou senha inválidos');
            }
            
            $hashDaSenha = hash_hmac('md5', $_POST['senha'], SALT_SENHA);
            $senhaNoBanco = $dadosUsuario[0]['senha'];
    
            $senhaValida = password_verify($hashDaSenha, $senhaNoBanco);
    
            if (!$senhaValida) {
                throw new Exception('Usuário ou senha inválidos');
            }
    
            $_SESSION['usuario'] = $dadosUsuario[0];
            $nome =  $_SESSION['usuario']['nome'];
            $_SESSION['usuario']['prinome'] = substr($nome , 0, strpos($nome, ' '));

            $usuarioLogado = new Usuario();
            $usuarioLogado->loadById( $dadosUsuario[0]['idusuario']);
            $usuarioLogado->qtdAcessos++;
            $usuarioLogado->save();
    
            redireciona('/admin/home');
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
            'class'=> 'row g-2',
            'btn_label'=>'Entrar',
            'btn_class'=>'btn normal',
            'fields'=>[
                    [
                        'type'=>'text',
                        'label'=>'Usuário',
                        'name'=>'email',
                        'placeholder'=> 'E-mail',
                        'required'=>true
                    ],
                    [
                        'type'=>'password',
                        'name'=>'senha',
                        'placeholder'=> 'Senha',
                        'required'=>true
                    ],
                ]
        ];
        return Render::block('form', $dados);
    }
}