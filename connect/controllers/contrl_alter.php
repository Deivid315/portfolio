<?php

session_start();
ob_start();

require_once __DIR__ . "../../models/token.php";


if ((time() - $_SESSION['time']) > 180) {
    header("location: ../views/admin/index.php?tempo=expirado");
    session_destroy();
} else {
    $altera = new Token;
    $altera->token = $_POST['token'];
    $altera->confirma();
    if ($altera->sucesso) {
        header("location: ../views/admin/inicial.php?Sucesso=true");
        exit;
    } else if ($altera->erro) {
        header("location: ../views/admin/inicial.php?Erro=true");
        exit;
    }else if ($altera->nulo) {
        header("location: ../views/admin/inicial.php?nulo=true");
        exit;
    }
}
