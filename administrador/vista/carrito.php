<?php include('../templates/header.php');
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$txtcliente = (isset($_POST['txtcliente'])) ? $_POST['txtcliente'] : "";
$txtTarjeta = (isset($_POST['txtTarjeta'])) ? $_POST['txtTarjeta'] : "";
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : "";
$codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : "";
date_default_timezone_set('America/Guayaquil');
$txtTotal = (isset($_POST['txtTotal'])) ? $_POST['txtTotal'] : "";
$txtObservaciones = (isset($_POST['txtObservaciones'])) ? $_POST['txtObservaciones'] : "";
$fecha = date("Y-m-d H-i-s");
switch ($accion) {
    case 'Eliminar':
        foreach ($_SESSION['carro'] as $key => $value) {
            if ($value['txtCodigo'] == $codigo) {
                unset($_SESSION['carro'][$key]);
            }
        }
        echo $codigo;

        echo "eliminar";
        break;

    case 'Pagar':
        $sqlTarjeta =  "SELECT * FROM tarjeta WHERE tar_numero=$txtTarjeta";
        $buscarTarjeta = $coon->query($sqlTarjeta);
        if ($buscarTarjeta == true) {
            foreach ($buscarTarjeta as $busca) {
                $idTarjeta = $busca['tar_id'];
            }
            $sqlCabecera = "INSERT INTO pedido_cabecera VALUES (0,'$fecha','$txtcliente','$txtTotal', '$txtObservaciones', '$idTarjeta')";
            if ($coon->query($sqlCabecera) == true) {
                $busCodPedido = "SELECT MAX(cab_id) FROM pedido_cabecera ";
                $rows = mysqli_fetch_array($coon->query($busCodPedido));
                $cabID = intval($rows[0]);
                $productoID =  array_column($_SESSION['carro'], "txtCodigo");
                $sentenciaSQL = "SELECT * FROM comida";
                $listado = $coon->query($sentenciaSQL);
                while ($row = mysqli_fetch_assoc($listado)) {
                    foreach ($productoID as $restaurantes) {
                        if ($row['com_id'] == $restaurantes) {
                            $idComida = $row['com_id'];
                            $subtotal = $row['com_presio'];
                            $sqlDetalle = "INSERT INTO pedido_detalle VALUES (0,'$subtotal',1,'$txtTotal', '$idComida', '$cabID')";
                            if($coon->query($sqlDetalle) == true){
                                foreach ($_SESSION['carro'] as $key => $value) {
                                    if ($value['txtCodigo'] == $idComida) {
                                        unset($_SESSION['carro'][$key]);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $sentenciaSQL = "DELETE FROM pedido_cabecera WHERE cab_id=$cabID ";
                $Seleccionado = $coon->query($sentenciaSQL);
            }
        }
        break;
}
?>
<link rel="stylesheet" href="../../css/bootstrap.min.css">
<div class="col-md-12">
    <form method="POST">
        <div class="row">
            <div class="col-md-8">
                <?php
                $total = 0;
                if (isset($_SESSION['carro'])) {
                    $productoID =  array_column($_SESSION['carro'], "txtCodigo");
                    $sentenciaSQL = "SELECT * FROM comida";
                    $listado = $coon->query($sentenciaSQL);
                    while ($row = mysqli_fetch_assoc($listado)) {
                        foreach ($productoID as $restaurantes) {
                            if ($row['com_id'] == $restaurantes) {

                                $total = $total + doubleval($row['com_presio']);
                ?>
                                <div class="card mb-8" style="max-width: 700px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="../../img/<?php echo $row['com_imagen']; ?>" class="img-fluid rounded-start" alt="...">
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card-body">
                                                <h1 class="card-title"><?php echo $row['com_nombre']; ?></h1>
                                                <p class="card-text">$ <?php echo $row['com_presio']; ?></p>
                                                <input type="hidden" name="codigo" id="codigo" value="<?php echo $row['com_id']; ?>" />
                                                <button type="submit" name="accion" value="Eliminar" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>

                <?php }
                        }
                    }
                } else {
                    echo "<h1>El Carrito esta Vacio</h1>";
                } ?>
            </div>
            <div class="col-md-3 offset-md-1 border rounded mt-5 bg-white h-25">
                <div class="row">
                    <h1>Ingrese Los datos de Pedidos</h1>
                    <div class="form-group">
                        <label class="form-label mt-4" for="readOnlyInput">Fecha:</label>
                        <input class="form-control" name="txtfecha" id="readOnlyInput" type="number" placeholder="<?php echo $fecha; ?>" readonly="">
                        <label class="form-label mt-4">Cliente:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="txtcliente" value="" placeholder="Cliente">
                            <label for="floatingInput">Cliente</label>
                        </div>
                        <label class="form-label mt-4">Tarjeta:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="txtTarjeta" id="txtTarjeta" value="" placeholder="Tarjeta">
                            <label for="floatingInput">Tarjeta</label>
                        </div>
                        <label class="form-label mt-4">Observaciones:</label>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="txtObservaciones" value="" placeholder="observacion">
                            <label for="floatingInput">Observaciones</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="row">
                            <div class="pt-4">
                                <h1>Detalles de Precio</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <?php if (isset($_SESSION['carro'])) {
                                    $contador = count($_SESSION['carro']);
                                    echo "<h2>Precio($contador items)</h2>";
                                } else {
                                    echo "<h2>Precio (o items)</h2>";
                                }

                                ?>
                            </div>
                            <div class="col-md-3">

                                <h2>$ <?php echo $total ?></h2>
                                <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo $total ?>" />
                            </div>
                        </div>
                        <button type="submit" name="accion" value="Pagar" class="btn btn-danger">Pagar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="../../js/buscarTarjetas.js" type="text/javascript"></script>

<?php include('../templates/footer.php'); ?>