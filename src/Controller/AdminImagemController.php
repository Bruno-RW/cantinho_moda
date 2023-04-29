<?php

namespace CantinhoModa\Controller;

use Gumlet\ImageResize;
use CantinhoModa\Core\Exception;
use CantinhoModa\Model\Arquivo;
use CantinhoModa\View\Render;

class AdminImagemController
{
    public function listar($model, $idmodel)
    {
        $modelPath = "CantinhoModa\\Model\\{$model}";
        if ( !class_exists($modelPath) ) {
            redireciona('/admin/dashboard', 'danger', 'Página não localizada, Classe de dados destino não definida');
        }

        $objetoComFiguras = new $modelPath;
        $objetoComFiguras->loadById($idmodel);

        // Alimentando os dados para a tabela de listagem
        $dadosListagem = [];
        $dadosListagem['objeto'] = new Arquivo();
        $dadosListagem['rows'] = $objetoComFiguras->getFiles();
        $dadosListagem['remover'] = true;
        $dadosListagem['colunas'] = [
            ['campo'=>'idarquivo',  'class'=>'text-center align-middle'],
            ['campo'=>'tipo',       'class'=>'text-center align-middle'],
            ['campo'=>'nome',       'class'=>'text-center align-middle'],
            ['campo'=>'tabela',     'class'=>'text-center align-middle'],
            ['campo'=>'tabelaid',   'class'=>'text-center align-middle'],
            ['campo'=>'created_at', 'class'=>'text-center align-middle'],
        ];
        $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'Imagens';
        $campoOrdenacao = $objetoComFiguras->getOrderByField();
        $dados['registroAlvo'] = $model . ': <u>' . $objetoComFiguras->$campoOrdenacao . '</u>';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['tabela'] = $htmlTabela;

        Render::back('imagens', $dados);
    }

    public function form($model, $idmodel, $valor)
    {
        $modelPath = "CantinhoModa\\Model\\{$model}";
        if ( !class_exists($modelPath) ) {
            redireciona('/admin/dashboard', 'danger', 'Página não localizada, Classe de dados destino não definida');
        }

        $objetoComFiguras = new $modelPath;
        $objetoComFiguras->loadById($idmodel);

        // Verifica se o parâmetro tem um número e, se for número, é um ID válido
        if ( is_numeric($valor) ) {
            $objeto = new Arquivo();
            $resultado = $objeto->find( ['idarquivo=' => $valor] );

            if ( empty($resultado) ) {
                redireciona("/admin/imagens/{$model}/{$idmodel}", 'danger', 'Link inválido, registro não localizado');
            }

            $_POST = $resultado[0];
        }

        // Cria e exibe o formulário
        $dados = [];
        $dados['titulo'] = 'Imagens - Manutenção';
        $dados['formulario'] = $this->renderizaFormulario( empty($_POST) );
        $campoOrdenacao = $objetoComFiguras->getOrderByField();
        $dados['registroAlvo'] = $model . ': <u class="d-inline-block mb-3">' . $objetoComFiguras->$campoOrdenacao . '</u>';
        
        Render::back('imagens', $dados);
    }

    public function postForm($model, $idmodel, $valor)
    {
        $objeto = new Arquivo();

        // Se $valor tem um número, carrega os dados o registro informado nele
        if ( is_numeric($valor) ) {
            if ( !$objeto->loadById($valor) ) {
                redireciona("/admin/imagens/{$model}/{$idmodel}", 'danger', 'Link inválido, registro não localizado');
            }
        }

        try {
            if ( !empty($_FILES['arquivo']['name']) ) {
                $_POST['nome'] = $_FILES['arquivo']['name'];
                $_POST['tipo'] = 'Imagem';
            }

            $modelPath = "CantinhoModa\\Model\\{$model}";
            if ( !class_exists($modelPath) ) {
                redireciona('/admin/dashboard', 'danger', 'Página não localizada, Classe de dados destino não definida');
            }
            
            // Pega as informações do objeto dono do arquivo, como nome
            // da tabela, nome do campo chave e valor do campo chave
            $objetoComFiguras = new $modelPath;
            $objetoComFiguras->loadById($idmodel);
            $tabela = $objetoComFiguras->getTableName();
            $tabelaChave = $objetoComFiguras->getPkName();
            $_POST['tabela'] = "{$tabela}.{$tabelaChave}";
            $_POST['tabelaid'] = $idmodel;

            $campos = array_change_key_case( $objeto->getFields() );
            foreach ($campos as $campo => $propriedades) {
                if ( isset($_POST[$campo]) ) {
                    $objeto->$campo = $_POST[$campo];
                }
            }
            $objeto->save();

            // Se foi enviado arquivo novo, mover para a pasta
            // de uploads com o id do arquivo como seu nome
            if ( !empty($_FILES['arquivo']['name']) ) {
                $nomeChave = $objeto->getPkName();
                $valorChave = $objeto->$nomeChave;
                $nomeArquivo = $valorChave . '.' . pathinfo($objeto->nome, PATHINFO_EXTENSION);
                $pathArquivo = PATH_PROJETO . 'public/assets/img/uploads/' . $nomeArquivo;

                if ( !move_uploaded_file($_FILES['arquivo']['tmp_name'], $pathArquivo) ) {
                    throw new Exception('Falha ao mover arquivo, verifique permissões');
                }

                rename($pathArquivo, $pathArquivo . '_original');
                $image = new ImageResize($pathArquivo . '_original');
                $image->crop(224, 320);
                $image->save($pathArquivo);
                unlink($pathArquivo . '_original');
            }

        } catch(Exception $e) {
            $_SESSION['mensagem'] = [
                'tipo' => 'danger',
                'texto' => $e->getMessage()
            ];
            $this->form($model, $idmodel, $valor);
            exit;
        }

        redireciona("/admin/imagens/{$model}/{$idmodel}", 'success', 'Alterações realizadas com sucesso');
    }

    public function renderizaFormulario($novo)
    {
        $dados = [
            'btn_class' => 'btn btn-primary px-5 my-5',
            'btn_label' => ($novo ? 'Adicionar' : 'Atualizar'),
            'enctype' => 'multipart/form-data',
            'fields' => [
                ['type'=>'readonly', 'name'=>'idarquivo',  'class'=>'col-1',  'label'=>'Id. Arquivo'],
                ['type'=>'readonly', 'name'=>'nome',       'class'=>'col-4',  'label'=>'Nome'],
                ['type'=>'readonly', 'name'=>'tipo',       'class'=>'col-2'],
                ['type'=>'file',     'name'=>'arquivo',    'class'=>'col-5',  'label'=>'Arquivo', 'accept'=>'image/*'],
                ['type'=>'textarea', 'name'=>'descricao',  'class'=>'col-12', 'label'=>'Descrição', 'rows'=>5],
                ['type'=>'readonly', 'name'=>'created_at', 'class'=>'col-3',  'label'=>'Criado em:'],
                ['type'=>'readonly', 'name'=>'updated_at', 'class'=>'col-3',  'label'=>'Atualizado em:']
            ]
        ];
        return Render::block('form', $dados);
    }
}