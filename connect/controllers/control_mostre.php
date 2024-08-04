<?php

if(isset($_POST['index'])){
    require_once __DIR__ . "../../models/filtro_mostre.php";

    $chave = new Fill;
    $chave->getmostre($_POST['index']);

}else if(isset($_POST['det']) && isset($_POST['es'])){
    require_once __DIR__ . "../../models/filtro_mostre.php";

    $chave = new Fill;
    $chave->getdetalhes($_POST['es'], $_POST['det']);
    
}else if(isset($_POST['esco'])){
    require_once __DIR__ . "../../models/filtro_mostre.php";

    $chave = new Fill;
    $chave->getescola($_POST['esco']);
    
}else{
    header("location: ../views/estudos/index.html");
    exit();
}

?>