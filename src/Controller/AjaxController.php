<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\DB;
use CantinhoModa\Core\SendMail;
use CantinhoModa\Model\ClienteJornal;
use CantinhoModa\Model\Produto;
use Respect\Validation\Validator as v;

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
     * Método responsável por enviar e-mail de contato
     *
     * @param array $dados Espera por: nome, e-mail, assunto e mensagem
     * @return void
    */
    public function emailContato(array $dados) : void
    {
        if ( empty($dados['nome']) || 
             empty($dados['email']) ||
             empty($dados['assunto']) ||
             empty($dados['mensagem']) ) {
            $this->retorno('error', 'Todos os campos devem ser preenchidos');
        }

        $nome     = trim($dados['nome']);
        $email    = trim($dados['email']);
        $assunto  = trim($dados['assunto']);
        $mensagem = trim($dados['mensagem']);

        if (strlen($nome) < 6) {
            $this->retorno('error', 'O nome precisa ser completo');
        }

        $emailValido = V::email()->validate($email);
        if (!$emailValido) {
            $this->retorno('error', 'O e-mail está incorreto');
        }

        if (strlen($assunto) < 4) {
            $this->retorno('error', 'Por favor, seja mais descritivo sobre o assunto');
        }

        if (strlen($mensagem) < 6) {
            $this->retorno('error', 'Por favor, seja mais descritivo na mensagem');
        }

        $dataMsg = date('d/m/Y H:i:s');
        $mensagemFull = <<<HTML
            - <strong>Nome</strong>: {$nome}<br>
            - <strong>E-mail</strong>: {$email}<br>
            - <strong>Assunto</strong>: {$assunto}<br>
            - <strong>Mensagem</strong>: {$mensagem}<br>
            <strong>Contato via site</strong> - {$dataMsg}
        HTML;

        SendMail::enviar(MAIL_CONTACTNAME, MAIL_CONTACTMAIL, $assunto, $mensagemFull, $nome, $email);
        
        $this->retorno('success', 'Mensagem enviada com sucesso');
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

        $sql = "SELECT ativo FROM favoritos WHERE idcliente = ? AND idproduto = ?";
        $params = [$_SESSION['cliente']['idcliente']??0, $produto->getIdProduto()];

        $produtoFavorito = DB::select($sql, $params)[0]['ativo'] ?? "N";

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
     * Método responsável por descadastrar e-mail do jornal eletrônico
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

        if ($clienteJornalLocalizado[0]['ativo'] == 'N') {
            $this->retorno('error', 'O e-mail já está descadastrado');
        }
        
        $news->loadById($clienteJornalLocalizado[0]['idclientejornal']);
        $news->ativo = 'N';

        $news->save();

        $this->retorno('success', 'O e-mail foi descadastrado com sucesso');
    }
}