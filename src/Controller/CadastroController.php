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
        $dados['titulo'] = 'Faça seu cadastro';
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
            'btn_label'=>'Cadastrar',
            'btn_class'=>'btn',
            'fields'=>[
                ['type'=>'text', 'name'=>'nome', 'required'=>true],
                ['type'=>'text', 'name'=>'email', 'required'=>true],
                ['type'=>'password', 'name'=>'senha', 'class'=>'col-6', 'required'=>true],
                ['type'=>'password', 'name'=>'senha2', 'class'=>'col-6', 'required'=>true]
            ]
        ];
        return Render::block('form', $dados);
    }
}