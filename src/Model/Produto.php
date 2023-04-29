<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;

#[Entidade(name: 'produtos')]
class Produto extends DAO
{
    #[Campo(label: 'Cód. Produto', pk: true, nn: true, auto: true)]
    protected $idProduto;

    #[Campo(label: 'Marca', nn: true)]
    protected $idMarca;

    #[Campo(label: 'Nome', nn: true, order: true)]
    protected $nome;

    #[Campo(label: 'Preço', nn: true)]
    protected $preco;

    #[Campo(label: 'Tamanho', nn: true)]
    protected $tamanho;

    #[Campo(label: 'Descrição')]
    protected $descricao;

    #[Campo(label: 'Especificações')]
    protected $especificacoes;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function getIdMarca()
    {
        return $this->idMarca;
    }
    public function setIdMarca(string $idMarca): self
    {
        $objMarca = new Marca;
        if ( !$objMarca->loadById($idMarca) ) {
            throw new Exception('A marca informada é inválida');
        }

        $this->idMarca = $idMarca;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome(string $nome): self
    {
        $nome = trim($nome);
        if (strlen($nome) < 3) {
            throw new Exception('Nome inválido para o produto');
        }

        $this->nome = $nome;
        return $this;
    }

    public function getPreco()
    {
        return $this->preco;
    }
    public function setPreco(string $preco): self
    {
        if ( !is_numeric($preco) || $preco < 0 ) {
            throw new Exception('Valor inválido para o produto');
        }

        $this->preco = $preco;
        return $this;
    }

    public function getTamanho()
    {
        return $this->tamanho;
    }
    public function setTamanho(string $tamanho): self
    {
        $tamanhosPermitidos = ['PP', 'P', 'M', 'G', 'GG', 'XGG', '34', '36', '36-38', '38', '40', '40-42', '42', '44', '44-46', '46', '48', '48-50', '50', '52', '54'];
        if ( !in_array($tamanho, $tamanhosPermitidos) ) {
            throw new Exception('Tamanho inválido para o produto');
        }
        
        $this->tamanho = $tamanho;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao(string $descricao): self
    {
        $descricao = trim($descricao);
        if ($descricao == '') {
            $this->descricao = null;
        } elseif (strlen($descricao) < 10) {
            throw new Exception('Descrição inválida para o produto');
        }

        $this->descricao = $descricao;
        return $this;
    }

    public function getEspecificacoes()
    {
        return $this->especificacoes;
    }
    public function setEspecificacoes(string $especificacoes): self
    {
        $especificacoes = trim($especificacoes);
        if ($especificacoes == '') {
            $this->especificacoes = null;
        } elseif (strlen($especificacoes) < 10) {
            throw new Exception('Especificação inválida para o produto');
        }
        
        $this->especificacoes = $especificacoes;
        return $this;
    }

    public function getCreated_At()
    {
        return $this->created_at;
    }
    public function getUpdated_At()
    {
        return $this->updated_at;
    }
}