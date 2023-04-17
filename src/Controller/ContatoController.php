<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Core\FrontController;
use CantinhoModa\Core\SendMail;
use CantinhoModa\View\Render;
use Respect\Validation\Validator as v;

class ContatoController extends FrontController
{
    public function contato()
    {
        $dados = [];
        $dados['titulo'] = 'Contato';
        $dados['topo'] = $this->carregaHTMLTopo();
        $dados['rodape'] = $this->carregaHTMLRodape();
        $dados['formulario'] = $this->formcontato();

        Render::front('contato', $dados);
    }

    public function postContato()
    {
        try {
            if ( empty($_POST['nome']) || 
                 empty($_POST['email']) ||
                 empty($_POST['mensagem']) ) {
                throw new Exception('Todos os campos devem ser preenchidos');
            }

            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $mensagem = trim($_POST['mensagem']);

            if (strlen($nome) < 6) {
                throw new Exception('O nome precisa ser completo');
            }

            $emailValido = V::email()->validate($email);
            if (!$emailValido) {
                throw new Exception('O e-mail está incorreto');
            }

            if (strlen($mensagem) < 6) {
                throw new Exception('Por favor, seja mais descritivo na mensagem');
            }

            $assunto = 'Contato via site - ' .date('d/m/Y H:i:s');
            $mensagemFull = <<<HTML
                Olá, chegou um novo contato<br>
                - <strong>Nome</strong>: {$nome}<br>
                - <strong>E-mail</strong>: {$email}<br>
                - <strong>Mensagem</strong>: {$mensagem}<br>
            HTML;

            SendMail::enviar(MAIL_CONTACTNAME, MAIL_CONTACTMAIL, $assunto, $mensagemFull, $nome, $email);

        } catch (Exception $e) {
            $_SESSION['mensagem'] = [
                'tipo' => 'warning',
                'texto' => $e->getMessage()
            ];
            $this->contato();
            exit;
        }
        
        redireciona('contato', 'success', 'Mensagem enviada com sucesso');
    }

    private function formContato()
    {
        $dados = [
            'btn_label'=>'Enviar mensagem',
            'btn_class'=>'btn',
            'fields'=>[
                ['type'=>'text', 'name'=>'nome', 'label'=>'Nome Completo', 'required'=>true],
                ['type'=>'email', 'name'=>'email', 'label'=>'E-mail', 'required'=>true],
                ['type'=>'textarea', 'name'=>'mensagem', 'label'=>'Mensagem', 'rows'=>5, 'required'=>true]
            ]
        ];
        return Render::block('form', $dados);
    }
}