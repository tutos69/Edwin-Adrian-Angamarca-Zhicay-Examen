<?php include('../templates/header.php'); ?>
<?php
$txtCodigo = (isset($_POST['txtCodigo'])) ? $_POST['txtCodigo'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$precio = doubleval($txtPrecio);

switch ($accion) {
    case 'Agregar':
        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtImagen']['name'] : "imagen.jpg";
        $tmpimagen = $_FILES['txtImagen']['tmp_name'];
        if ($tmpimagen != "") {
            move_uploaded_file($tmpimagen, '../../img/'. $nombreArchivo);
        }
        $agregarProductos = "INSERT INTO comida VALUES (0,'$txtNombre','$precio','$nombreArchivo', '$idSeccion')";
        if ($coon->query($agregarProductos) == true) {
        } else {
            echo "No Vale" . mysqli_error($coon);
        }
        header('Locatio:AgregarComida.php');
        echo 'Agregar';
        break;

    case 'Modificar':
        $actualizaComida = "UPDATE comida SET com_nombre='$txtNombre', com_precio='$precio' WHERE com_id=$txtCodigo ";
        $actualiza = $coon->query($actualizaComida);

        if ($txtImagen != "") {
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtImagen']['name'] : "imagen.jpg";
            $tmpimagen = $_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpimagen, '../../img/'. $nombreArchivo);
            $buscaImagen = "SELECT com_imagen FROM comida WHERE com_id=$txtCodigo ";
            $buscaI = $coon->query($buscaImagen);
            foreach ($buscaI as $buscaIma) {
                if (isset($buscaIma["com_imagen"]) && ($buscaIma["com_imagen"] != "imagen.jpg")) {
                    if (file_exists('../../img/'. $buscaIma['com_imagen'])) {
                        unlink('../../img/'. $buscaIma['com_imagen']);
                    }
                }
            }

            $actualizaComida = "UPDATE comida SET com_imagen='$nombreArchivo' WHERE com_id=$txtCodigo ";
            $actualiza = $coon->query($actualizaComida);
        }
        header('Locatio:AgregarComida.php');
        echo 'Modificar';
        break;

    case 'Cancelar':
        echo 'Cancelar';
        break;
    case 'Selecionar':
        $selecionar = "SELECT * FROM comida WHERE com_id=$txtCodigo ";
        $Seleccionado = $coon->query($selecionar);
        foreach ($Seleccionado as $productoss) {
            $txtNombre = $productoss['com_nombre'];
            $txtPrecio = $productoss['com_presio'];
            $txtImagne = $productoss['com_imagen'];
        }
        echo 'Seleccionar';
        break;
    case 'Borrar':
        $sentenciaSQL = "SELECT com_imagen FROM comida WHERE com_id=$txtCodigo ";
        $Seleccionado = $coon->query($sentenciaSQL);
        foreach ($Seleccionado as $productoss) {
            if (isset($productoss["com_imagen"]) && ($productoss["com_imagen"] != "imagen.jpg")) {
                if (file_exists('../../img/' . $productoss['com_imagen'])) {
                    unlink('../../img/' . $productoss['com_imagen']);
                }
            }
        }

        $sentenciaSQL = "DELETE FROM comida WHERE com_id=$txtCodigo ";
        $Seleccionado = $coon->query($sentenciaSQL);
        header('Locatio:AgregarComida.php');
        echo 'Borrar';
        break;
}

$ListaSql = "SELECT * FROM comida";
$lista = $coon->query($ListaSql);
?>



<link rel="stylesheet" href="../../css/bootstrap.min.css">

<div class="container">
    <br>
    <div class="row">
        <div class="col-md-5">

            <div class="card">
                <div class="card-body">
                    <h1>Registre La Comida</h1> 
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-floating mb-3">
                                <input type="hidden" class="form-control" value="<?php echo $txtCodigo; ?> "name="txtCodigo" placeholder="Codigo">
                            </div>
                            <label class="form-label mt-4">Nombre Comida:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" placeholder="nombrePlatillo">
                                <label for="floatingInput">Nombre Comida</label>
                            </div>
                            <label class="form-label mt-4">Precio:</label>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" placeholder="Precio">
                                <label for="floatingInput">Precio</label>
                            </div>
                            <label class="form-label mt-4">Imagen:</label> <img src="../../img/<?php echo $txtImagne; ?>" width="70" alt=""> 
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control"  name="txtImagen" placeholder="imagen">
                                <label for="floatingInput">Imagen</label>
                            </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" <?php echo ($accion=='Selecionar')?'disabled':'';?>  value="Agregar" class="btn btn-success">Agregar</button>
                            <button type="submit" name="accion"  <?php echo ($accion!='Selecionar')?'disabled':'';?>  value="Modificar" class="btn btn-warning">Modificar</button>
                            <button type="submit" name="accion"  <?php echo ($accion!='Selecionar')?'disabled':'';?> value="Cancelar" class="btn btn-info">Canccelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <table class="table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $producto) { ?>
                        <tr>
                            <td><?php echo $producto['com_id']; ?></td>
                            <td><?php echo $producto['com_nombre']; ?></td>
                            <td><?php echo $producto['com_presio']; ?></td>
                            <td>
                                <img src="../../img/<?php echo $producto['com_imagen']; ?>" width="50" alt="">
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="txtCodigo" id="txtCodigo" value="<?php echo $producto['com_id']; ?>" />
                                    <input type="submit" name="accion" value="Selecionar" class="btn btn-success">
                                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include('../templates/footer.php'); ?>