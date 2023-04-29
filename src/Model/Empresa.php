<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Exception;
use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use Respect\Validation\Validator as v;

#[Entidade(name: 'empresas')]
class Empresa extends DAO
{
    #[Campo(label: 'Cód. Empresa', pk: true, nn: true, auto: true)]
    protected $idEmpresa;

    #[Campo(label: 'Nome fantasia', nn: true, order: true)]
    protected $nomeFantasia;

    #[Campo(label: 'Razão social', nn: true)]
    protected $razaoSocial;

    #[Campo(label: 'Tipo', nn: true)]
    protected $tipo;

    #[Campo(label: 'CEP', nn: true)]
    protected $cep;

    #[Campo(label: 'Cidade', nn: true)]
    protected $cidade;

    #[Campo(label: 'Estado', nn: true)]
    protected $estado;

    #[Campo(label: 'Rua')]
    protected $rua;
    
    #[Campo(label: 'Bairro')]
    protected $bairro;

    #[Campo(label: 'Número')]
    protected $numero;

    #[Campo(label: 'Sala')]
    protected $sala;

    #[Campo(label: 'Telefone 1', nn: true)]
    protected $telefone1;

    #[Campo(label: 'Telefone 2')]
    protected $telefone2;

    #[Campo(label: 'Site')]
    protected $site;

    #[Campo(label: 'E-mail', nn: true)]
    protected $email;

    #[Campo(label: 'CPNJ', nn: true)]
    protected $cnpj;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }
    public function setNomeFantasia(string $nomeFantasia): self
    {
        $nomeFantasia = trim($nomeFantasia);
        $tamanhoValido = v::stringType()->length(1,255)->validate($nomeFantasia);

        if (!$tamanhoValido) {
            throw new Exception('O tamanho no Nome Fantasia é inválido');
        }
        
        $this->nomeFantasia = $nomeFantasia;
        return $this;
    }

    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }
    public function setRazaoSocial(string $razaoSocial): self
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo(string $tipo): self
    {
        $tipoValido = in_array($tipo, ['Matriz', 'Filial']);

        if (!$tipoValido) {
            throw new Exception('O tipo deve ser de Matriz ou Filial apenas');
        }

        $this->tipo = $tipo;
        return $this;
    }

    public function getCep()
    {
        return $this->cep;
    }
    public function setCep(string $cep): self
    {
        $cepValido = v::postalCode('BR')->validate($cep);

        if (!$cepValido) {
            throw new Exception('O campo CEP tem valor inválido');
        }

        $this->cep = $cep;
        return $this;
    }

    public function getCidade()
    {
        return $this->cidade;
    }
    public function setCidade(string $cidade): self
    {
        $cidade = trim($cidade);
        $tamanhoValido = v::stringType()->length(3, 35)->validate($cidade);

        if (!$tamanhoValido) {
            throw new Exception('O tamanho do valor no campo Cidade é inválido');
        }

        $this->cidade = $cidade;
        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado(string $estado): self
    {
        $estado = trim($estado);
        $tamanhoValido = v::stringType()->length(2, 3)->validate($estado);

        if (!$tamanhoValido) {
            throw new Exception('O tamanho do valor no campo Estado é inválido');
        }

        $this->estado = $estado;
        return $this;
    }

    public function getRua()
    {
        return $this->rua;
    }
    public function setRua(string $rua): self
    {
        $this->rua = $rua;

        return $this;
    }

    public function getBairro()
    {
        return $this->bairro;
    }
    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }
    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSala()
    {
        return $this->sala;
    }
    public function setSala(string $sala): self
    {
        $this->sala = $sala;

        return $this;
    }

    public function getTelefone1()
    {
        return $this->telefone1;
    }
    public function setTelefone1(string $telefone1): self
    {
        $telefone1 = trim($telefone1);
        $tipoValido = v::phone()->validate($telefone1);

        if (!$tipoValido) {
            throw new Exception('O campo Telefone 01 tem valor inválido');
        }

        $this->telefone1 = $telefone1;
        return $this;
    }

    public function getTelefone2()
    {
        return $this->telefone2;
    }
    public function setTelefone2(string $telefone2): self
    {
        $telefone2 = trim($telefone2);
        $tipoValido = v::phone()->validate($telefone2);

        if ($telefone2 == '') {
            $this->telefone2 = null;
            return $this;
        } 
        
        if (!$tipoValido) {
            throw new Exception('O campo Telefone 02 tem valor inválido');
        }

        $this->telefone2 = $telefone2;
        return $this;
    }

    public function getSite()
    {
        return $this->site;
    }
    public function setSite(string $site): self
    {
        $site = trim($site);
        $tipoValido = v::url()->validate($site);

        if ($site == '') {
            $this->site = null;
            return $this;
        } 

        if (!$tipoValido) {
            throw new Exception('O campo Site tem valor inválido');
        }

        $this->site = $site;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $email = trim($email);
        $tipoValido = v::email()->validate($email);

        if (!$tipoValido) {
            throw new Exception('O campo E-mail tem valor inválido');
        }

        $this->email = $email;
        return $this;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function setCnpj(string $cnpj): self
    {
        $tipoValido = v::cnpj()->validate($cnpj);

        if (!$tipoValido) {
            throw new Exception('O campo CNPJ tem valor inválido');
        }

        $this->cnpj = $cnpj;
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