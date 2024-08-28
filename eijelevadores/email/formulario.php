

<?php


$nome = $_POST['nome'];
$email = $_POST['email'];
$celular = $_POST['celular'];
$opcoes = $_POST['opcoes'];
$data_envio = date('d/m/Y');

if($opcoes == 1){
    $opcoes = "Manutenção Preventiva";
};

if($opcoes == 2){
    $opcoes = "Elevador Novo";
};

if($opcoes == 3){
    $opcoes = "Emergências";
};

if($opcoes == 4){
    $opcoes = "Outros";
};

if(($nome != "") || ($email != "") || ($opcoes !="") || ($opcoes !="")){

$arquivo = "
<html lang='pt-br'>
<head>
<meta charset='UTF-8' />
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
  </head>
  <body>
        <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
            <tr>
              <td>
  <tr>
                 <td width='500'>Nome:<b>$nome</b></td>
                </tr>
                <tr>
                  <td width='320'>E-mail:<b>$email</b></td>
     </tr>
     <td width='320'>Celular:<b>$celular</b></td>
</tr>
<td width='320'>Objetivo:<b>$opcoes</b></td>
</tr>
     
            </td>
          </tr>
          <tr>
            <td>Este e-mail foi enviado em $data_envio</b></td>
          </tr>
        </table>
        </body>
    </html>
  ";

  $emailenviar = "*******";
  $destino = $emailenviar;
  $assunto = "Contato pelo Site";

  // É necessário indicar que o formato do e-mail é html
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: ' . $nome . ' <$email>';
  //$headers .= "Bcc: $EmailPadrao\r\n";

  $enviaremail = mail($destino, $assunto, $arquivo, $headers);

  if($enviaremail){
    echo '<!DOCTYPE html>';
    echo '<html lang="pt-br">';
    echo '<head>';
    echo '
    <meta charset="UTF-8" />
    <link rel="icon" type="image/webp" href="/img/icon.webp">
    <title>EIJ Elevadores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Magnos">
    <meta http-equiv="Content-Language" content="pt-br">
    <link rel="canonical" href="https://eijelevadores.com">
    <meta name="robots" content="noindex">
    <meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />';
    echo '<meta http-equiv="refresh" content="5; url=https://eijelevadores.com">';
    echo '<style type="text/css">';
    echo '
    body{
        width: 100vw;
        heigth: 100vh;
        overflow-x: hidden;
        overflow-y: hidden;
        margin: 0;
        padding: 0;
    }

    .emailenviado{
        overflow-x: hidden;
        overflow-y: hidden;
        width: 100vw;
        height: 100vh;
        background-color: #747474;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .emailenviado p{
        width: 90%;
        font-size: 20px;
        color: white;
      }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="emailenviado"><p>Seu email foi enviado com sucesso. A página será carregada em 5 segundos...</p></div>';
    echo '</body>';
    echo '</html>';
  }else{
    echo '<!DOCTYPE html>';
    echo '<html lang="pt-br">';
    echo '<head>';
    echo '
    <meta charset="UTF-8" />
    <link rel="icon" type="image/webp" href="/img/icon.webp">
    <title>EIJ Elevadores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Magnos">
    <meta http-equiv="Content-Language" content="pt-br">
    <link rel="canonical" href="https://eijelevadores.com">
    <meta name="robots" content="noindex">
    <meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />';
    echo '<meta http-equiv="refresh" content="7; url=https://eijelevadores.com">';
    echo '<style type="text/css">';
    echo '.emailenviado{
        width: 100vw;
        height: 100vh;
        background-color: #747474;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .emailenviado p{
        width: 90vw;
        font-size: 20px;
        color: white;
      }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="emailenviado"><p>Houve um erro durante o envio do email, nos contate pelo whatsapp. A página será carregada em 5 segundos...</p></div>';
    echo '</body>';
    echo '</html>';
  }

}else{
    header('location:https://eijelevadores.com');
    
}
?>

