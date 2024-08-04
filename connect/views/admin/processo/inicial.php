<?php
declare(strict_types=1);

session_start();
ob_start();

function redirectWithError(string $message): void {
    header("location: /views/admin/index.php?logado=false&message=$message");
    session_destroy();
    exit();
}

function redirectToIndex(): void {
    header("location: ../views/admin/index.php?tempo=expirado");
    session_destroy();
    exit();
}

if (!isset($_SESSION['nome_admin'], $_SESSION['id_admin'])) {
    redirectWithError("Você deve estar logado para acessar essa página.");
}

if (!isset($_SESSION['time'])) {
    $_SESSION['time'] = time();
}

if ((time() - (int)$_SESSION['time']) > 300) {
    redirectToIndex();
} else {
    $_SESSION['time'] = time();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="style.css">
    <script src="js.js"></script>

</head>

<body>

    <nav>
        <ul>
            <li id="in"><a href="#">Instagram</a></li>
            <li id="es"><a href="#">Escolas</a></li>
            <li id="es"><a href="../../models/exit.php" style="color: red;">Sair</a></li>
        </ul>
    </nav>

    <h1>Bem vindo admin</h1>

    <div id="instagram">
        <h2>Instagram</h2>
        <p class="pp">Para que na página principal o Instagram continue a funcionar é necessário
            um token de acesso, todavia esse token dura apenas 60 dias, portanto cabe ao
            admin acessar essa página a cada período para atualizar o token, do contrário
            o instagram desaparecerá da página principal.
        </p>

        <form action="../../controllers/contrl_alter.php" method="post">
            <label for="texttoken">Chave Token</label>
            <textarea name="token" id="texttoken" cols="60" rows="5" autocomplete="off"></textarea>
            <input type="submit" value="Enviar">
        </form>

        <div id="atual">
            <h2>A chave token atual é:</h2>
            <p>
                <?php
                echo $_SESSION['token'];
                ?>

            </p>
        </div>
    </div>

    <div id="escolas">

        <h2>Estados</h2>
        <p>Escolha o estado que deseja editar:</p>
        <div id="estate">
            <span data-index="ca">Califórnia</span>
            <span data-index="cn">Connecticut</span>
            <span data-index="co">Colorado</span>
            <span data-index="dc">D.C.</span>
            <span data-index="fl">Flórida</span>
            <span data-index="ge">Geórgia</span>
            <span data-index="hi">Havaí</span>
            <span data-index="il">Illinóis</span>
            <span data-index="ind">Indiana</span>
            <span data-index="md">Maryland</span>
            <span data-index="ms">Massassuchets</span>
            <span data-index="nj">New Jersey</span>
            <span data-index="ny">Nova York</span>
            <span data-index="sc">South Califórnia</span>
            <span data-index="tx">Texas</span>
            <span data-index="ut">Utah</span>
            <span data-index="va">Virgínia</span>
            <span data-index="wa">Washington</span>
        </div>
        <div id="s_cs">
        <h2>Estado selecionado: <span></span></h2>
        <p>Escolha a escola que deseja editar:</p>
        <div id="school_city">
        </div>

        </div>

        <div id="selecao">

        <div class="titulo_estado">
            <h1></h1>
        </div>

            <div class="titulo_escolas_d">
                <h1></h1>
            </div>
            <div class="primeiro">
                <span class="pergun l_pri loc">Localizações:</span>
                <span class="resp prime respl"></span>
            </div>
            <div class="primeiro">
                <span class="pergun mat">Matrícula:</span>
                <span class="resp respm"></span>
            </div>
            <div class="primeiro">
                <span class="pergun val">Valores:</span>
                <div class="varl">
                    <span>1º mês - <span class="3m"></span></span><br>
                    <span>2º mês - <span class="6m"></span></span><br>
                    <span>3º mês - <span class="12m"></span></span><br>
                </div>
            </div>
            <div class="primeiro com">
                <span class="pergun">Comprovação Financeira:</span>
                <div class="comp ult">
                    <span>3 meses - <span class="3c"></span></span><br>
                    <span>6 meses - <span class="6c"></span></span><br>
                    <span>9 meses - <span class="9c"></span></span><br>
                    <span>12 meses - <span class="12c"></span></span><br>
                </div>

            </div>
            <fieldset>
                <legend>Selecione o que você quer editar:</legend>

                <div>
                    <input type="checkbox" id="cidade" name="cidade">
                    <label for="cidade">Cidades</label>
                </div>

                <div>
                    <input type="checkbox" id="matricula" name="matricula">
                    <label for="matricula">Matrícula</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_3" name="mv_3">
                    <label for="mv_3">Valores do 1º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_6" name="mv_6">
                    <label for="mv_6">Valores do 2º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_12" name="mv_12">
                    <label for="mv_12">Valores do 3º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_3" name="mc_3">
                    <label for="mc_3">Comprovação do 3º mês + dependente</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_6" name="mc_6">
                    <label for="mc_6">Comprovação do 6º mês + dependente</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_9" name="mc_9">
                    <label for="mc_9">Comprovação do 9º mês + dependente</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_12" name="mc_12">
                    <label for="mc_12">Comprovação do 12º mês + dependente</label>
                </div>

                <input type="button" value="Enviar" id="button" disabled>
            </fieldset>

            <div id="alter">
                <h1>Altere as infomações selecionadas: <span class="al_es"></span></h1>
                <form action="../../controllers/control_submi_sc.php" method="get" class="al" id="form_altere">

                </form>
            </div>

        </div>
        
    </div>

</body>

</html>