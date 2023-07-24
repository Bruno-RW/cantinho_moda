<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\Core\Exception;
use CantinhoModa\Model\Categoria;
use CantinhoModa\Model\Marca;
use CantinhoModa\Model\Produto;
use CantinhoModa\View\Render;

class AdminProdutoController
{
    public function listar()
    {
        $sql = 'SELECT p.idproduto, p.nome, p.tamanho, m.marca idmarca, c.nome idcategoria,
                       FORMAT(p.preco, 2, "pt_BR") preco 
                FROM produtos p
                INNER JOIN marcas m on m.idmarca = p.idmarca
                INNER JOIN categorias c on c.idcategoria = p.idcategoria
                ORDER BY p.nome';
        $rows = DB::select($sql);
        
        // Alimentando os dados para a tabela de listagem
        $dadosListagem = [];
        $dadosListagem['objeto'] = new Produto();
        $dadosListagem['rows'] = $rows;
        $dadosListagem['imagens'] = true;
        $dadosListagem['colunas'] = [
            ['campo'=>'idproduto',   'class'=>'text-center align-middle'],
            ['campo'=>'nome',        'class'=>'text-center align-middle'],
            ['campo'=>'idcategoria', 'class'=>'text-center align-middle'],
            ['campo'=>'idmarca',     'class'=>'text-center align-middle'],
            ['campo'=>'tamanho',     'class'=>'text-center align-middle'],
            ['campo'=>'preco',       'class'=>'text-center align-middle'],
        ];
        $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Produtos';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['tabela'] = $htmlTabela;

        Render::back('produtos', $dados);
    }

    public function form($valor)
    {
        // Verifica se o parâmetro tem um número e, se for número, é um ID válido
        if ( is_numeric($valor) ) {
            $objeto = new Produto();
            $resultado = $objeto->find( ['idproduto =' => $valor] );

            if ( empty($resultado) ) {
                redireciona('/admin/produtos', 'danger', 'Link inválido, registro não localizado');
            }

            $_POST = $resultado[0];
            $_POST['preco']        = number_format($_POST['preco'], 2, ',', '');
        }

        // Cria e exibe o formulário
        $dados = [];
        $dados['titulo'] = 'Produtos - Manutenção';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['formulario'] = $this->renderizaFormulario( empty($_POST) );
        
        Render::back('produtos', $dados);
    }

    public function postForm($valor)
    {
        $objeto = new Produto();

        // Se $valor tem um número, carrega os dados o registro informado nele
        if ( is_numeric($valor) ) {
            if ( !$objeto->loadById($valor) ) {
                redireciona('/admin/produtos', 'danger', 'Link inválido, registro não localizado');
            }
        }

        try {
            // Definindo os campos que têm valores decimais
            // e estão vindo com vírgula no lugar de ponto
            $camposDecimal = ['preco'];

            $campos = array_change_key_case( $objeto->getFields() );
            foreach ($campos as $campo => $propriedades) {
                if ( isset($_POST[$campo]) ) {
                    // Se o campo é DECIMAL, então, altera vírgula por ponto
                    if (in_array($campo, $camposDecimal)) {
                        $_POST[$campo] = str_replace(',', '.', $_POST[$campo]);
                    }
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

        redireciona('/admin/produtos', 'success', 'Alterações realizadas com sucesso');
    }
    
    public function renderizaFormulario($novo)
    {
        $marcas = ( new Marca )->find();
        $optionsMarca = [];
        foreach ($marcas as $m) {
            $optionsMarca[] = [ 'value'=>$m['idmarca'], 'label'=>$m['marca'] ];
        }

        $categorias = ( new Categoria )->find();
        $optionsCategoria = [];
        foreach ($categorias as $c) {
            $optionsCategoria[] = [ 'value'=>$c['idcategoria'], 'label'=>$c['nome'] ];
        }

        $dados = [
            'btn_class' => 'btn btn-primary px-5 mt-3',
            'btn_label' => ($novo ? 'Adicionar' : 'Atualizar'),
            'fields' => [
                ['type'=>'readonly', 'name'=>'idproduto',   'class'=>'col-1', 'label'=>'Id. Produto'],
                ['type'=>'text',     'name'=>'nome',        'class'=>'col-3', 'label'=>'Nome',      'required'=>true],
                ['type'=>'select',   'name'=>'idcategoria', 'class'=>'col-2', 'label'=>'Categoria', 'required'=>true, 'options'=>$optionsCategoria],
                ['type'=>'select', 'name'=>'idmarca', 'class'=>'col-2', 'label'=>'Marca', 'required'=>true, 'options'=>$optionsMarca],
                ['type'=>'select', 'name'=>'tamanho', 'class'=>'col-2', 'required'=>true,
                    'options'=>[
                        ['value'=>'PP',      'label'=>'PP'],
                        ['value'=>'P',       'label'=>'P'],
                        ['value'=>'M',       'label'=>'M'],
                        ['value'=>'G',       'label'=>'G'],
                        ['value'=>'GG',      'label'=>'GG'],
                        ['value'=>'XGG',     'label'=>'XGG'],
                        ['value'=>'34',      'label'=>'34'],
                        ['value'=>'36',      'label'=>'36'],
                        ['value'=>'36-38',   'label'=>'36-38'],
                        ['value'=>'38',      'label'=>'38'],
                        ['value'=>'40',      'label'=>'40'],
                        ['value'=>'40-42',   'label'=>'40-42'],
                        ['value'=>'42',      'label'=>'42'],
                        ['value'=>'44',      'label'=>'44'],
                        ['value'=>'44-46',   'label'=>'44-46'],
                        ['value'=>'46',      'label'=>'46'],
                        ['value'=>'48',      'label'=>'48'],
                        ['value'=>'48-50',   'label'=>'48-50'],
                        ['value'=>'50',      'label'=>'50'],
                        ['value'=>'52',      'label'=>'52'],
                        ['value'=>'54',      'label'=>'54']
                    ]
                ],
                ['type'=>'text',   'name'=>'preco',   'class'=>'col-2', 'label'=>'Preço', 'required'=>true],

                ['type'=>'textarea', 'name'=>'descricao', 'class'=>'col-12', 'label'=>'Descrição', 'rows'=>5],
                ['type'=>'textarea', 'name'=>'especificacoes', 'class'=>'col-12', 'label'=>'Especificações', 'rows'=>5],

                ['type'=>'readonly', 'name'=>'created_at', 'class'=>'col-3', 'label'=>'Criado em:'],
                ['type'=>'readonly', 'name'=>'updated_at', 'class'=>'col-3', 'label'=>'Atualizado em:']
            ]
        ];
        return Render::block('form', $dados);
    }
}