<?php

require_once __DIR__ . "../../models/valid.php";

$valida = new Valida();
$valida->login_usuario = $_POST['login_usuario'];
$valida->senha_usuario = $_POST['senha_usuario'];
$valida->confirma();


