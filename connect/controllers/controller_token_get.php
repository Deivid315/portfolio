<?php

    
   if(isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false || strpos($_SERVER['HTTP_ACCEPT'], 'text/javascript') !== false)) {
    // A solicitação parece ser uma solicitação AJAX
    echo 'Solicitação AJAX detectada';
} else {
    // A solicitação não parece ser uma solicitação AJAXrequire_once $_SERVER['DOCUMENT_ROOT'] . "/models/token.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/token.php";

$chave = new Token;
$token = $chave->getmostre();
echo $token;

}


?>
