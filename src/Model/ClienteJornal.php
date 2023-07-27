<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;
use Respect\Validation\Validator as v;

#[Entidade(name: 'clientesJornal')]
class ClienteJornal extends DAO
{
    #[Campo(label: 'Cód. Cliente', pk: true, nn: true, auto: true)]
    protected $idClienteJornal;

    #[Campo(label: 'E-mail', nn: true)]
    protected $email;

    #[Campo(label: 'Ativo', nn: true)]
    protected $ativo;

    #[Campo(label: 'Recebidos', nn: true, order: true)]
    protected $recebidos;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdClienteJornal()
    {
        return $this->idClienteJornal;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $email = strtolower(trim($email));
        $emailValido = v::email()->validate($email);

        if (!$emailValido) {
            throw new Exception('O e-mail informado é inválido');
        }

        $this->email = $email;
        return $this;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }
    public function setAtivo($ativo): self
    {
        $this->ativo = $ativo;

        return $this;
    }

    public function getRecebidos()
    {
        return $this->recebidos;
    }
    public function setRecebidos($recebidos): self
    {
        $this->recebidos = $recebidos;

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