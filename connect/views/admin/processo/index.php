<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="robots" content="noindex, nofollow">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>

        body{
            background-color: #000080;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: 40px;
            margin: 0;
            padding: 0;
            color: white;
            flex-direction: column;
            width: 100vw;
            height: 100vh;
        }

        form{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        #invalid{
            width: 250px;
            top: 0;
            height: auto;
            padding: 10px;
            position: absolute;
            display: none;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: red;
            transition: opacity 1s linear;
        }
    </style>
<?php 
    session_start();
    ob_start();
    
    if ((isset($_SESSION['login']) && $_SESSION['login']) || (isset($_SESSION['senha']) && $_SESSION['senha'])) {
        ?>
        <script>
            window.onload = function () {  
                var select = document.getElementById("invalid");
                select.style.display = "flex";
                setTimeout(() => {
                    select.style.opacity = "0"
                    setTimeout(() => {
                    select.style.display = "none";
                        
                    }, 1000);
                }, 3000);
            }
        </script>
<?php } 
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
?>

<script>
    
    const urlParams = new URLSearchParams(window.location.search);

const logado = urlParams.get('logado');
const tempoExcedido = urlParams.get('tempo');

if (logado) {
    alert("Você precisa estar logado para acessar essa página!");
    urlParams.delete('logado');
    const newUrl = window.location.pathname + '?' + urlParams.toString();
    window.history.replaceState({}, document.title, newUrl);
} else if (tempoExcedido) {
    alert("O tempo de inatividade foi superior ao limite estabelecido, por favor refaça o login!");
    urlParams.delete('tempo');
    const newUrl = window.location.pathname + '?' + urlParams.toString();
    window.history.replaceState({}, document.title, newUrl);
}
</script>
    
</head>
<body>
<div id="invalid">
    <p>Senha ou usuário incorretos</p>
</div>
        <h1>Login</h1><br>
        
        <form method="POST" action="../../controllers/rote.php">
        <label>Usuário</label>
        <input type="text" id="login" name="login_usuario" placeholder="Digite o usuário" value="" autocomplete="off"><br><br>

        <label>Senha</label>
        <input type="password" id="senha" name="senha_usuario" placeholder="Digite a senha" value="" autocomplete="off"><br><br>

        <input type="submit" id="enviar" value="Acessar" name="enviar" disabled>
    </form>
        <script>
    
    var loginInput = document.getElementById("login");
    var senhaInput = document.getElementById("senha");
    var enviarButton = document.getElementById("enviar");

    loginInput.addEventListener("input", verificarCampos);
    senhaInput.addEventListener("input", verificarCampos);

    function verificarCampos() {
        if (loginInput.value.trim() !== "" && senhaInput.value.trim() !== "") {
            enviarButton.disabled = false;
        } else {
            enviarButton.disabled = true;
        }
    }
</script>
</body>
</html>