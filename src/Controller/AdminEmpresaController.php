<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Model\Empresa;
use CantinhoModa\View\Render;

class AdminEmpresaController
{
    public function listar()
    {
        // Alimentando os dados para a tabela de listagem
        $dadosListagem = [];
        $dadosListagem['objeto'] = new Empresa();
        $dadosListagem['imagens'] = true;
        $dadosListagem['colunas'] = [
            ['campo'=>'idempresa',    'class'=>'text-center align-middle'],
            ['campo'=>'razaosocial',  'class'=>'text-center align-middle'],
            ['campo'=>'tipo',         'class'=>'text-center align-middle'],
            ['campo'=>'cidade',       'class'=>'text-center align-middle'],
            ['campo'=>'estado',       'class'=>'text-center align-middle'],
            ['campo'=>'email',        'class'=>'text-center align-middle'],
            ['campo'=>'telefone1',    'class'=>'text-center align-middle'],
            ['campo'=>'created_at',   'class'=>'text-center align-middle'],
        ];
        $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Empresas';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['tabela'] = $htmlTabela;

        Render::back('empresas', $dados);
    }

    public function form($valor)
    {
        // Verifica se o parâmetro tem um número e, se for número, é um ID válido
        if ( is_numeric($valor) ) {
            $objeto = new Empresa();
            $resultado = $objeto->find( ['idempresa =' => $valor] );

            if ( empty($resultado) ) {
                redireciona('/admin/empresas', 'danger', 'Link inválido, registro não localizado');
            }

            $_POST = $resultado[0];
        }

        // Cria e exibe o formulário
        $dados = [];
        $dados['titulo'] = 'Empresas - Manutenção';
        $dados['formulario'] = $this->renderizaFormulario( empty($_POST) );
        
        Render::back('empresas', $dados);
    }

    public function postForm($valor)
    {
        $objeto = new Empresa();

        // Se $valor tem um número, carrega os dados o registro informado nele
        if ( is_numeric($valor) ) {
            if ( !$objeto->loadById($valor) ) {
                redireciona('/admin/empresas', 'danger', 'Link inválido, registro não localizado');
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

        redireciona('/admin/empresas', 'success', 'Alterações realizadas com sucesso');
    }

    public function renderizaFormulario($novo)
    {
        $dados = [
            'btn_class' => 'btn btn-primary px-5 mt-3',
            'btn_label' => ($novo ? 'Adicionar' : 'Atualizar'),
            'fields' => [
                ['type'=>'readonly', 'name'=>'idempresa', 'class'=>'col-2', 'label'=>'Id. Empresa'],
                ['type'=>'text', 'name'=>'nomefantasia', 'class'=>'col-5', 'label'=>'Nome fantasia', 'required'=>true],
                ['type'=>'text', 'name'=>'razaosocial', 'class'=>'col-5', 'label'=>'Razão social', 'required'=>true],

                ['type'=>'select', 'name'=>'tipo', 'class'=>'col-2', 'required'=>true,
                    'options'=>[
                        ['value'=>'Matriz', 'label'=>'Matriz'],
                        ['value'=>'Filial', 'label'=>'Filial'],
                    ]
                ],
                ['type'=>'text', 'name'=>'cnpj', 'class'=>'col-3', 'label'=>'CNPJ', 'required'=>true,],
                ['type'=>'text', 'name'=>'cep', 'class'=>'col-2', 'label'=>'CEP', 'required'=>true],

                ['type'=>'text', 'name'=>'cidade', 'class'=>'col-5', 'required'=>true],
                ['type'=>'text', 'name'=>'estado', 'class'=>'col-5', 'required'=>true],

                ['type'=>'text', 'name'=>'rua', 'class'=>'col-5'],
                ['type'=>'text', 'name'=>'numero', 'class'=>'col-2', 'label'=>'Número'],

                ['type'=>'text', 'name'=>'bairro', 'class'=>'col-4'],
                ['type'=>'text', 'name'=>'telefone1', 'class'=>'col-4', 'label'=>'Telefone 1', 'required'=>true],
                ['type'=>'text', 'name'=>'telefone2', 'class'=>'col-4', 'label'=>'Telefone 2'],

                ['type'=>'text', 'name'=>'site', 'class'=>'col-6'],
                ['type'=>'text', 'name'=>'email', 'class'=>'col-6', 'label'=>'E-mail', 'required'=>true,],

                ['type'=>'readonly', 'name'=>'created_at', 'class'=>'col-3', 'label'=>'Criado em:'],
                ['type'=>'readonly', 'name'=>'updated_at', 'class'=>'col-3', 'label'=>'Atualizado em:']
            ]
        ];
        return Render::block('form', $dados);
    }
}