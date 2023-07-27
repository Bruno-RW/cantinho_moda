<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Model\ClienteJornal;
use CantinhoModa\View\Render;

class AdminNotificadoController
{
    public function listar()
    {
        // Alimentando os dados para a tabela de listagem
        $dadosListagem = [];
        $dadosListagem['objeto'] = new ClienteJornal();
        $dadosListagem['colunas'] = [
            ['campo'=>'idclientejornal', 'class'=>'text-center align-middle'],
            ['campo'=>'email',           'class'=>'text-center align-middle'],
            ['campo'=>'ativo',           'class'=>'text-center align-middle'],
            ['campo'=>'recebidos',       'class'=>'text-center align-middle'],
            ['campo'=>'created_at',      'class'=>'text-center align-middle'],
        ];
        $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Notificados';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['tabela'] = $htmlTabela;

        Render::back('notificados', $dados);
    }

    public function form($valor)
    {
        // Verifica se o parâmetro tem um número e, se for número, é um ID válido
        if ( is_numeric($valor) ) {
            $objeto = new ClienteJornal();
            $resultado = $objeto->find( ['idclientejornal =' => $valor] );

            if ( empty($resultado) ) {
                redireciona('/admin/notificados', 'danger', 'Link inválido, registro não localizado');
            }

            $_POST = $resultado[0];
            $_POST['senha'] = '';
        }

        // Cria e exibe o formulário
        $dados = [];
        $dados['titulo'] = 'Notificados - Manutenção';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['formulario'] = $this->renderizaFormulario( empty($_POST) );
        
        Render::back('notificados', $dados);
    }

    public function postForm($valor)
    {
        $objeto = new ClienteJornal();

        // Se $valor tem um número, carrega os dados o registro informado nele
        if ( is_numeric($valor) ) {
            if ( !$objeto->loadById($valor) ) {
                redireciona('/admin/notificados', 'danger', 'Link inválido, registro não localizado');
            }
        }

        try {
            $campos = array_change_key_case( $objeto->getFields() );
            foreach ($campos as $campo => $propriedades) {
                if ( isset($_POST[$campo]) ) {
                    $objeto->$campo = $_POST[$campo];
                }
            }
            $objeto->save();

        } catch(Exception $e) {
            $_SESSION['mensagem'] = [
                'tipo' => 'danger',
                'texto' => $e->getMessage()
            ];
            $this->form($valor);
            exit;
        }

        redireciona('/admin/notificados', 'success', 'Alterações realizadas com sucesso');
    }

    public function renderizaFormulario($novo)
    {
        $dados = [
            'btn_class' => 'btn btn-primary px-5 mt-3',
            'btn_label' => ($novo ? 'Adicionar' : 'Atualizar'),
            'fields' => [
                ['type'=>'readonly', 'name'=>'idclientejornal', 'class'=>'col-2',  'label'=>'Id. Cliente'],
                ['type'=>'text',     'name'=>'email',           'class'=>'col-6',  'label'=>'E-mail',       'required'=>true],
                ['type'=>'text',     'name'=>'ativo',           'class'=>'col-2',  'label'=>'Ativo',        'required'=>true],
                ['type'=>'text',     'name'=>'recebidos',       'class'=>'col-2',  'label'=>'Recebidos',    'required'=>true],
                ['type'=>'readonly', 'name'=>'created_at',      'class'=>'col-3',  'label'=>'Criado em:'],
                ['type'=>'readonly', 'name'=>'updated_at',      'class'=>'col-3',  'label'=>'Atualizado em:'],
            ]
        ];
        return Render::block('form', $dados);
    }
}