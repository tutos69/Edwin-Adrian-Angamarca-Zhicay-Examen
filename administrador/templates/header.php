<?php
session_start();
$idSeccion = $_SESSION['idUsuario'];
if (($idSeccion == null) || ($idSeccion == '')) {
  header('Location:../../index.php');
  die();
}else{
  include('../config/conexion.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="../../css/styles.css">
</head>

<body>
  <!-- partial:index.partial.html -->
  <header>
    <div class="menu-toggle" id="hamburger">
      <i class="fas fa-bars"></i>
    </div>
    <div class="overlay"></div>
    <div class="container">
      <nav>
        <h1 class="brand"><a href="index.php">Br<span>a</span>nd</a></h1>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../vista/Productos.php">Comidas</a></li>
          <li><a href="../vista/AgregarComida.php">Agregar Comida</a></li>
          <li><a href="../vista/Tarjeta.php">Agregar Tarjeta</a></li>
         
          <li><a href="../vista/carrito.php">Carrito <?php if(isset($_SESSION['carro'])){
            $contador = count($_SESSION['carro']);
            echo $contador;
            }else{
              echo '<span>0</span>';
            }

            ?>   </a></li>
          <li><a href="../controlador/cerrarSesion.php">Salir</a></li>
        </ul>
      </nav>