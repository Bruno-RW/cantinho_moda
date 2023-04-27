<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;

#[Entidade(name: 'arquivos')]
class Arquivo extends DAO
{
    #[Campo(label: 'Cód. Arquivo', pk: true, nn: true, auto: true)]
    protected $idArquivo;

    #[Campo(label: 'Nome', nn: true, order: true)]
    protected $nome;

    #[Campo(label: 'Tipo', nn: true)]
    protected $tipo;

    #[Campo(label: 'Descrição')]
    protected $descricao;
    
    #[Campo(label: 'Tabela')]
    protected $tabela;

    #[Campo(label: 'Cód. Tabela')]
    protected $tabelaId;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    #[Campo(label: 'Dt. Alteração', nn: true, auto: true)]
    protected $updated_at;

    public function getIdArquivo()
    {
        return $this->idArquivo;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome(string $nome): self
    {
        $nome = trim($nome);
        if (!$nome) {
            throw new Exception('Nome inválido para o arquivo');
        }

        $this->nome = $nome;
        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo(string $tipo): self
    {
        $tipo = trim($tipo);
        if (!$tipo) {
            throw new Exception('Tipo inválido para o arquivo');
        }
        $this->tipo = $tipo;
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
            return $this->descricao == null;
        } elseif (strlen($descricao) < 5) {
            throw new Exception('Descrição inválida para o arquivo');
        }

        $this->descricao = $descricao;
        return $this;
    }

    public function getTabela()
    {
        return $this->tabela;
    }
    public function setTabela($tabela): self
    {
        $this->tabela = $tabela;

        return $this;
    }

    public function getTabelaId()
    {
        return $this->tabelaId;
    }
    public function setTabelaId($tabelaId): self
    {
        $this->tabelaId = $tabelaId;

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