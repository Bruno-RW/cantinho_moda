<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\Model\ClienteJornal;
use CantinhoModa\Model\Favorito;
use CantinhoModa\Model\Produto;

class AjaxController
{
    /**
     * Função que recebe as ações solicitadas e escolhe método que deve ser executado
     *
     * @return void
    */
    public function loader()
    {
        if ( empty($_POST['acao']) ) {
            $this->retorno('error', 'Ação não definida, contate o suporte');
        }

        if ( !method_exists($this, $_POST['acao']) ) {
            $this->retorno('error', 'Ação não implementada, contate o suporte');
        }

        $acao = $_POST['acao'];

        $this->$acao($_POST);
    }

    /**
     * Retorna um objeto JSON para o cliente
     *
     * @param string $status success, error, info, warning, question
     * @param string $mensagem
     * @param array $dados
     * @return void
    */
    public function retorno(string $status, string $mensagem, array $dados=[])
    {
        $resposta = [
            'status'   => $status,
            'mensagem' => $mensagem,
            'dados'    => $dados
        ];

        header('Content-type: application/json; charset=utf-8');
        die( json_encode($resposta) );
    }


    // IMPLEMENTAR FUNÇÕES DE RETORNO DE AJAX DAQUI PARA BAIXO

    /**
     * Método responsável por pegar os dados recebidos e processar,
     * marcando os produtos curtidos como favoritos
     *
     * @param array $dados Espera no mínimo: idproduto
     * @return void
    */
    public function curtir(array $dados)
    {
        if ( empty($_SESSION['cliente']) ) {
            $this->retorno('error', 'Você precisa fazer o login antes');
        }

        $produto = new Produto();
        if ( empty($dados['idproduto']) || !$produto->loadById($dados['idproduto']) ) {
            $this->retorno('error', 'O produto informado não existe');
        }

        $sql = 'SELECT idfavorito, ativo
                FROM favoritos
                WHERE idproduto = ?
                AND idcliente = ?';
        $parametros = [ $dados['idproduto'], $_SESSION['cliente']['idcliente'] ];

        $rows = DB::select($sql, $parametros);

        $curtiu = true;

        if (!$rows) {
            $sql = 'INSERT INTO favoritos (idproduto, idcliente) VALUES (?, ?)';
        } else if ($rows[0]['ativo'] == 'N') {
            $sql = 'UPDATE favoritos SET ativo = "S" WHERE idproduto = ? AND idcliente = ?';
        } else {
            $sql = 'UPDATE favoritos SET ativo = "N" WHERE idproduto = ? AND idcliente = ?';
            $curtiu = false;
        }

        $st = DB::query($sql, $parametros);

        if ( $st->rowCount() ) {
            $this->retorno('success', 'Ação registrada com sucesso', ['curtiu'=>$curtiu]);
        }
        
        $this->retorno('error', 'Falha ao registrar ação, nehnum registro alterado');
    }

    /**
     * Método responsável por passar informações do produto para o modal
     *
     * @param array $dados Espera no mínimo: idproduto
     * @return void
    */
    public function detalhaProduto(array $dados)
    {
        $produto = new Produto();
        if ( !$produto->loadById($dados['idproduto']) ) {
            $this->retorno('error', 'O produto é inválido');
        }

        $sql = "SELECT idcategoria, nome FROM categorias WHERE idcategoria IS NOT NULL";
        $nomesCategorias[] = DB::select($sql);

        foreach ($nomesCategorias[0] as $c) {
            if ( $c['idcategoria'] == $produto->getIdCategoria() ) {
                $produtoCategoria = $c['nome'];
            }
        }

        $sql = "SELECT idmarca , marca FROM marcas WHERE idmarca IS NOT NULL";
        $nomeMarcas[] = DB::select($sql);

        foreach ($nomeMarcas[0] as $m) {
            if ( $m['idmarca'] == $produto->getIdMarca() ) {
                $produtoMarca = $m['marca'];
            }
        }

        $favorito = new Favorito;
        $produtoFavorito = $favorito->find( ["idproduto ="=>"{$produto->getIdProduto()}"], [], "ativo" );

        $desconto = 0.15;
        $precoDesconto = round( $produto->getPreco() * (1 - $desconto), 2 );
        $precoParcela = round( $produto->getPreco() / 4, 2 );

        $produtoData = [
            'id'             => $produto->getIdProduto(),
            'imagens'        => $produto->getFiles(),
            'marca'          => $produtoMarca,
            'categoria'      => $produtoCategoria,
            'nome'           => $produto->getNome(),
            'favorito'       => $produtoFavorito,
            'preco'          => $produto->getPreco(),
            'precodesconto'  => $precoDesconto,
            'precoparcela'   => $precoParcela,
            'tamanho'        => $produto->getTamanho(),
            'descricao'      => $produto->getDescricao(),
            'especificacoes' => $produto->getEspecificacoes(),
        ];

        $this->retorno('success', 'Ação registrada com sucesso', ['produto'=>$produtoData]);
    }

    /**
     * Método responsável por cadastrar e-mail para receber
     * notificações da loja através do jornal eletrônico
     *
     * @param array $dados Espera o e-mail informado
     * @return void
    */
    public function cadastraNews(array $dados) : void
    {
        if ( !filter_var($dados['email'], FILTER_VALIDATE_EMAIL) ) {
            $this->retorno('error', 'O e-mail é inválido');
        }

        $news = new ClienteJornal();

        $clienteJornalLocalizado = $news->find(['email='=>$dados['email']]);
        if ($clienteJornalLocalizado) {
            $news->loadById($clienteJornalLocalizado[0]['idclientejornal']);
        }
        
        $news->email = $dados['email'];
        $news->ativo = 'S';

        if (!$clienteJornalLocalizado) {
            $news->recebidos = 0;
        }

        $news->save();

        $this->retorno('success', 'O e-mail foi cadastrado com sucesso');
    }

    /**
     * Método responsável por descadastrar
     * e-mail do jornal eletrônico
     *
     * @param array $dados Espera o e-mail informado
     * @return void
    */
    public function cancelaNews(array $dados) : void
    {
        if ( !filter_var($dados['email'], FILTER_VALIDATE_EMAIL) ) {
            $this->retorno('error', 'O e-mail é inválido');
        }

        $news = new ClienteJornal();

        $clienteJornalLocalizado = $news->find(['email='=>$dados['email']]);
        if (!$clienteJornalLocalizado) {
            $this->retorno('error', 'E-mail não registrado');
        }
        
        $news->loadById($clienteJornalLocalizado[0]['idclientejornal']);
        $news->ativo = 'N';

        $news->save();

        $this->retorno('success', 'O e-mail foi descadastrado com sucesso');
    }
}