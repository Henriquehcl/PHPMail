<?php
$user='japahard@gmail.com';
$password='hcorrea123';
$remetente='japahard@gmail.com';
$resposta='japahard@gmail.com';
$destinatario='henriquehcl@hotmail.com';
$assunto='Teste com variavel';
$mensagem='conteudo.html';

//classes usadas no PHPmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

$mail = new PHPMailer;

$mail->isSMTP();

//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
//$mail->SMTPDebug = SMTP::DEBUG_OFF;

//configurando o host de envio de e-mail
$mail->Host = 'smtp.gmail.com';

//configurando a porta de saida de e-mail
$mail->Port = 587;

//tipo de encriptação do e-mail
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//autenticação do SMTP
$mail->SMTPAuth = true;

//Seu login do Gmail
$mail->Username = $user;

//Sua senha do Gmail
$mail->Password = $password;

//E-mail e nome do remetente que vai aparecer no corpo de email
$mail->setFrom($remetente, 'Seu Nome');

//E-mail para receber a resposta
$mail->addReplyTo($resposta, 'Seu Nome');

//destinatario do e-mail
$mail->addAddress($destinatario, 'Nome quem recebe o email');

//Assunto do e-mail
$mail->Subject = $assunto;

//corpo da menssagem, pode ser um arquivo em HTML, imagem, etc...
$mail->msgHTML(file_get_contents($mensagem), __DIR__);



//Verificando se o e-mail foi enviado sem erros
if (!$mail->send()) {
    echo 'Encontramos problemas!: '. $mail->ErrorInfo;
} else {
    echo 'Mensagem enviada!';

}


function save_mail($mail)
{
    
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}
?>