<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Model\Marca;
use CantinhoModa\View\Render;

class AdminMarcaController
{
    public function listar()
    {
        // Alimentando os dados para a tabela de listagem
        $dadosListagem = [];
        $dadosListagem['objeto'] = new Marca();
        $dadosListagem['colunas'] = [
            ['campo'=>'idmarca',    'class'=>'text-center align-middle'],
            ['campo'=>'marca',      'class'=>'text-center align-middle'],
            ['campo'=>'fabricante', 'class'=>'text-center align-middle'],
            ['campo'=>'created_at', 'class'=>'text-center align-middle'],
        ];
        $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Marcas';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['tabela'] = $htmlTabela;

        Render::back('marcas', $dados);
    }

    public function form($valor)
    {
        // Verifica se o parâmetro tem um número e, se for número, é um ID válido
        if ( is_numeric($valor) ) {
            $objeto = new Marca();
            $resultado = $objeto->find( ['idmarca =' => $valor] );

            if ( empty($resultado) ) {
                redireciona('/admin/marcas', 'danger', 'Link inválido, registro não localizado');
            }

            $_POST = $resultado[0];
        }

        // Cria e exibe o formulário
        $dados = [];
        $dados['titulo'] = 'Marcas - Manutenção';
        $dados['formulario'] = $this->renderizaFormulario( empty($_POST) );
        
        Render::back('marcas', $dados);
    }

    public function postForm($valor)
    {
        $objeto = new Marca();

        // Se $valor tem um número, carrega os dados o registro informado nele
        if ( is_numeric($valor) ) {
            if ( !$objeto->loadById($valor) ) {
                redireciona('/admin/marcas', 'danger', 'Link inválido, registro não localizado');
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

        redireciona('/admin/marcas', 'success', 'Alterações realizadas com sucesso');
    }

    public function renderizaFormulario($novo)
    {
        $dados = [
            'btn_class' => 'btn btn-primary px-5 mt-3',
            'btn_label' => ($novo ? 'Adicionar' : 'Atualizar'),
            'fields' => [
                ['type'=>'readonly', 'name'=>'idmarca', 'class'=>'col-3', 'label'=>'Id. Marca'],
                ['type'=>'text', 'name'=>'marca', 'class'=>'col-4', 'label'=>'Nome da marca', 'required'=>true],
                ['type'=>'text', 'name'=>'fabricante', 'class'=>'col-5', 'label'=>'Fabricante da marca'],
                ['type'=>'readonly', 'name'=>'created_at', 'class'=>'col-3', 'label'=>'Criado em:'],
                ['type'=>'readonly', 'name'=>'updated_at', 'class'=>'col-3', 'label'=>'Atualizado em:']
            ]
        ];
        return Render::block('form', $dados);
    }
}