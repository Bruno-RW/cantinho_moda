<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;
use Respect\Validation\Validator as v;

#[Entidade(name: 'clientes')]
class Cliente extends DAO
{
    #[Campo(label: 'Cód. Cliente', pk: true, nn: true, auto: true)]
    protected $idCliente;

    #[Campo(label: 'Nome', nn: true, order: true)]
    protected $nome;

    #[Campo(label: 'E-mail', nn: true)]
    protected $email;

    #[Campo(label: 'Senha', nn: true)]
    protected $senha;

    #[Campo(label: 'Jornal', nn: true)]
    protected $jornal;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
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

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        if ($this->senha && !$senha) {
            return $this;
        }
        
        if (strlen($senha) < 5) {
            throw new Exception('O comprimento da senha é inválido, digite ao menos cinco caracteres');
        }

        $hashDaSenha = hash_hmac('md5', $senha, SALT_SENHA);
        $senha = password_hash($hashDaSenha, PASSWORD_DEFAULT);

        $this->senha = $senha;
        return $this;
    }

    public function getJornal()
    {
        return $this->senha;
    }

    public function setJornal(string $jornal): self
    {
        $this->jornal = $jornal;

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