<?php

namespace CantinhoModa\Controller;

use CantinhoModa\Core\Exception;
use CantinhoModa\Model\ClienteJornal;
use CantinhoModa\Model\MensagemJornal;
use CantinhoModa\View\Render;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class AdminNewsMsgController
{
    public function listar()
    {
        // Alimentando os dados para a tabela de listagem
        $dadosListagem = [];
        $dadosListagem['objeto'] = new MensagemJornal();
        $dadosListagem['colunas'] = [
            ['campo'=>'idmensagemjornal',    'class'=>'text-center align-middle'],
            ['campo'=>'assunto',             'class'=>'text-center align-middle'],
            ['campo'=>'texto',               'class'=>'text-center align-middle'],
            ['campo'=>'created_at',          'class'=>'text-center align-middle'],
        ];
        $htmlTabela = Render::block('tabela-admin', $dadosListagem);

        // Alimentando os dados para a página de listagem
        $dados = [];
        $dados['titulo'] = 'News Mensagens';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['tabela'] = $htmlTabela;

        Render::back('news-msg', $dados);
    }

    public function form($valor)
    {
        // Verifica se o parâmetro tem um número e, se for número, é um ID válido
        if ( is_numeric($valor) ) {
            $objeto = new MensagemJornal();
            $resultado = $objeto->find( ['idmensagemjornal =' => $valor] );

            if ( empty($resultado) ) {
                redireciona('/admin/news-msg', 'danger', 'Link inválido, registro não localizado');
            }

            $_POST = $resultado[0];
            $_POST['senha'] = '';
        }

        // Cria e exibe o formulário
        $dados = [];
        $dados['titulo'] = 'News Mensagens - Manutenção';
        $dados['usuario'] = $_SESSION['usuario'];
        $dados['formulario'] = $this->renderizaFormulario( empty($_POST) );
        
        Render::back('news-msg', $dados);
    }

    public function postForm($valor)
    {
        $objeto = new MensagemJornal();

        // Se $valor tem um número, carrega os dados o registro informado nele
        if ( is_numeric($valor) ) {
            if ( !$objeto->loadById($valor) ) {
                redireciona('/admin/news-msg', 'danger', 'Link inválido, registro não localizado');
            }
        }

        try {
            $campos = array_change_key_case( $objeto->getFields() );
            foreach ($campos as $campo => $propriedades) {
                if ( isset($_POST[$campo]) ) {
                    $objeto->$campo = $_POST[$campo];
                }
            }
            $objeto->save();

        } catch(Exception $e) {
            $_SESSION['mensagem'] = [
                'tipo' => 'danger',
                'texto' => $e->getMessage()
            ];
            $this->form($valor);
            exit;
        }

        $objCliente = new ClienteJornal();
        $localizados = $objCliente->find(
            ['ativo=' => 'S']
        );

        foreach($localizados as $cadastrado) {
            $objCliente->loadById($cadastrado['idclientejornal']);

            $this->enviaMensagemCadastrada($_POST['assunto'], $_POST['texto'], $objCliente->getEmail());

            $objCliente->recebidos = $objCliente->recebidos + 1;

            $objCliente->save();
        }

        redireciona('/admin/news-msg', 'success', 'Alterações realizadas com sucesso');
    }

    public function renderizaFormulario($novo)
    {
        $dados = [
            'btn_class' => 'btn btn-primary px-5 mt-3',
            'btn_label' => ($novo ? 'Adicionar' : 'Atualizar'),
            'fields' => [
                ['type'=>'readonly', 'name'=>'idmensagemjornal', 'class'=>'col-2',  'label'=>'Id. Mensagem'],
                ['type'=>'text',     'name'=>'assunto',          'class'=>'col-10', 'label'=>'Assunto da mensagem', 'required'=>true],
                ['type'=>'textarea', 'name'=>'texto',            'class'=>'col-12', 'label'=>'Texto da mensagem', 'rows'=>5, 'required'=>true],
                ['type'=>'readonly', 'name'=>'created_at',       'class'=>'col-3',  'label'=>'Criado em:'],
            ]
        ];
        return Render::block('form', $dados);
    }

    private function enviaMensagemCadastrada($assunto, $mensagem, $destinatario) {
        $assunto = $assunto . ' - ' . date('d/m/y');

        $mensagem = nl2br($mensagem);
        $mensagem .= '<br><br>Para cancelar o recebimento de notificações, acesse este <a href="{URL}/cancelar-jornal">link</a>';
        
        $mail = new PHPMailer(true);

        try {
            //Configurações de servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USER;
            $mail->Password   = MAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MAIL_PORT;

            //Recipientes
            $mail->setFrom(MAIL_USER, MAIL_NAME);
            $mail->addAddress($destinatario);

            $mail->addReplyTo('cantinhomodahz@gmail.com', 'Cantinho da Moda');

            //Conteúdo
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem;
            $mail->AltBody = 'Esta mensagem está formatada com HTML, abra no navegador';

            if ( !$mail->send() ) {
                error_log('Erro de e-mail: ' . $mail->ErrorInfo);
                throw new Exception('Erro ao enviar mensagem, tente novamente mais tarde');
            }
            return true;
        } catch (Exception $e) {
            error_log('Erro de e-mail: ' . $mail->ErrorInfo);
            throw new Exception('Erro do processo de envio de mensagem');
        }
    }
}
