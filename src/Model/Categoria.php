<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;

#[Entidade(name: 'categorias')]
class Categoria extends DAO
{
    #[Campo(label: 'Cód. Categoria', pk: true, nn: true, auto: true)]
    protected $idCategoria;

    #[Campo(label: 'Nome', nn: true, order: true)]
    protected $nome;

    #[Campo(label: 'Descrição')]
    protected $descricao;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $nome = trim($nome);
        if (strlen($nome) < 3) {
            throw new Exception('Nome inválido para categoria');
        }
        
        $this->nome = $nome;
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
        } elseif(strlen($descricao) < 10) {
            throw new Exception('Descrição inválida para categoria');
        }
        
        $this->descricao = $descricao;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}