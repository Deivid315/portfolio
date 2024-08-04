<?php
date_default_timezone_set('America/Sao_Paulo');

// Função para validar o email
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Inicializa o array de resposta
$resposta = array();

// Verifica se todos os campos do formulário foram preenchidos
if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['telefone']) && !empty($_POST['informacoes'])) {
    $nome = htmlspecialchars($_POST['nome']);
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $informacoes = htmlspecialchars($_POST['informacoes']);
    $data_envio = date('d/m/Y');
    $hora_envio = date('H:i:s');

    // Valida o email
    if(validarEmail($email)) {
        $arquivo = "
            <html>
            <meta charset='UTF-8'>
            <body>
                <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
                    <tr>
                        <td>
                            <tr>
                                <td width='500'>Nome: $nome</td>
                            </tr>
                            <tr>
                                <td width='320'>E-mail: <b>$email</b></td>
                            </tr>
                            <tr>
                                <td width='320'>Telefone: <b>$telefone</b></td>
                            </tr>
                            <tr>
                                <td width='320'>Tópico: <b>$informacoes</b></td>
                            </tr>
                        </td>
                    </tr>
                    <tr>
                        <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
                    </tr>
                </table>
            </body>
            </html>
        ";

        // Define o email de destino
        $email_destino = "matheus@connectionusa.net";
        $assunto = "Contato pelo Site";

        // Cabeçalhos do email
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= "From: $nome <$email>" . "\r\n";

        // Envia o email
        if(mail($email_destino, $assunto, $arquivo, $headers)) {
            $resposta['sucesso'] = true;
        } else {
            $resposta['falha'] = true;
        }
    } else {
        $resposta['email_invalido'] = true;
    }
} else {
    $resposta['campos_vazios'] = true;
}

// Retorna a resposta em formato JSON
echo json_encode($resposta);
?>
