<?php

//php básico de envio de email na forma procedural.

$nome = $_POST['nome'];
$email = $_POST['e-mail'];
$telefone = $_POST['ddd'] . $_POST['numero'];
$empresa = $_POST['empresa'];
$servico = $_POST['servico'];
$site = $_POST['site'];
$data_envio = date('d/m/Y');
$hora_envio = date('H:i:s');

$arquivo = "
  <style type='text/css'>
  body {
  margin:0px;
  font-family:Verdane;
  font-size:12px;
  color: #666666;
  }
  a{
  color: #666666;
  text-decoration: none;
  }
  a:hover {
  color: #FF0000;
  text-decoration: none;
  }
  </style>
    <html>
        <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
            <tr>
              <td>
  <tr>
                 <td width='500'>Nome:$nome</td>
                </tr>
                <tr>
                  <td width='320'>E-mail:<b>$email</b></td>
     </tr>
      <tr>
                  <td width='320'>Telefone:<b>$telefone</b></td>
                </tr>
     <tr>
                  <td width='320'>Empresa:$empresa</td>
                </tr>
                <tr>
                  <td width='320'>Serviço:$servico</td>
                </tr>
                <tr>
                  <td width='320'>Site:$site</td>
                </tr>
            </td>
          </tr>
          <tr>
            <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
          </tr>
        </table>
    </html>
  ";

$emailenviar = "**********";
$destino = $emailenviar;
$assunto = "Contato pelo Site";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: $nome <$email>';

$enviaremail = mail($destino, $assunto, $arquivo, $headers);

if ($enviaremail) {
  header('location:index.html?mensagem=sucesso');
} else {
  header('location:index.html?mensagem=erro');
}
