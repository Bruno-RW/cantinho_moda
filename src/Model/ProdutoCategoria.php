<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;

#[Entidade(name: 'produtos_categorias')]
class ProdutoCategoria extends DAO
{
    #[Campo(label: 'Cód. Produto', pk: true, nn: true)]
    protected $idProduto;
    
    #[Campo(label: 'Cód. Categoria', pk: true, nn: true)]
    protected $idCategoria;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function setIdProduto($idProduto): self
    {
        $this->idProduto = $idProduto;

        return $this;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria): self
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    public function getCreated_At()
    {
        return $this->created_at;
    }
}