<?php
    session_start();
    session_destroy();
    include '../config/conexion.php';
    $coon->close();
    header('Location:../../index.php');
    
?>