<?php

namespace CantinhoModa\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use CantinhoModa\Core\Exception as CantinhoModaException;

class SendMail
{
    public static function enviar(string $paraNome, string $paraEmail, string $assunto, string $mensagem, string $replyToName = '', $replyToEmail = '')
    {
        // Cria uma instância e habilita as excessões (true)
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
            $mail->addAddress($paraEmail, $paraNome);

            if ( $replyToName && $replyToEmail ) {
                $mail->addReplyTo($replyToEmail, $replyToName);
            }

            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            //Conteúdo
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem;
            $mail->AltBody = 'Esta mensagem está formatada com HTML, abra no navegador';

            if ( !$mail->send() ) {
                error_log('Erro de e-mail: ' . $mail->ErrorInfo);
                throw new CantinhoModaException('Erro ao enviar mensagem, tente novamente mais tarde');
            }
            return true;
        } catch (Exception $e) {
            error_log('Erro de e-mail: ' . $mail->ErrorInfo);
            throw new CantinhoModaException('Erro do processo de envio de mensagem');
        }
    }
}
