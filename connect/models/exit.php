<?php

    session_start();
    ob_start();
    
    unset($_SESSION['id_admin'], $_SESSION['nome_admin']);
    session_destroy();

    header("Location: ../views/admin/index.php");
    
?>