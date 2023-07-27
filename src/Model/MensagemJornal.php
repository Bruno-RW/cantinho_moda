<?php

namespace CantinhoModa\Model;

use CantinhoModa\Core\Attribute\Campo;
use CantinhoModa\Core\Attribute\Entidade;
use CantinhoModa\Core\DAO;
use CantinhoModa\Core\Exception;

#[Entidade(name: 'mensagensJornal')]
class MensagemJornal extends DAO
{
    #[Campo(label: 'Cód. Mensagem', pk: true, nn: true, auto: true)]
    protected $idMensagemJornal;

    #[Campo(label: 'Assunto', nn: true)]
    protected $assunto;

    #[Campo(label: 'Texto', nn: true)]
    protected $texto;

    #[Campo(label: 'Dt. Criação', nn: true, auto: true)]
    protected $created_at;

    public function getIdMensagemJornal()
    {
        return $this->idMensagemJornal;
    }

    public function getAssunto()
    {
        return $this->assunto;
    }
    public function setAssunto(string $assunto): self
    {
        $assunto = trim($assunto);
        if ($assunto == '') {
            $this->assunto = null;
        } elseif (strlen($assunto) < 7) {
            throw new Exception('Assunto inválido para a notícia');
        }

        $this->assunto = $assunto;
        return $this;
    }

    public function getTexto()
    {
        return $this->texto;
    }
    public function setTexto(string $texto): self
    {
        $texto = trim($texto);
        if ($texto == '') {
            $this->texto = null;
        } elseif (strlen($texto) < 10) {
            throw new Exception('Texto inválido para a notícia');
        }

        $this->texto = $texto;
        return $this;
    }

    public function getCreated_At()
    {
        return $this->created_at;
    }
}