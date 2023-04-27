<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;

#[Entidade(name: 'marcas')]
class Marca extends DAO
{
    #[Campo(label: 'Cód. Marca', pk: true, nn: true, auto: true)]
    protected $idMarca;

    #[Campo(label: 'Nome', nn: true, order: true)]
    protected $marca;

    #[Campo(label: 'Fabricante')]
    protected $fabricante;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdMarca()
    {
        return $this->idMarca;
    }

    public function getMarca()
    {
        return $this->marca;
    }
    public function setMarca(string $marca): self
    {
        $marca = trim($marca);
        if (strlen($marca) < 3) {
            throw new Exception('Marca inválida');
        }

        $this->marca = $marca;
        return $this;
    }

    public function getFabricante()
    {
        return $this->fabricante;
    }
    public function setFabricante(string $fabricante): self
    {
        $fabricante = trim($fabricante);
        if ($fabricante == '') {
            $this->fabricante = null;
        } elseif (strlen($fabricante) < 3) {
            throw new Exception('Nome de fabricante inválido');
        }
        $this->fabricante = $fabricante;
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