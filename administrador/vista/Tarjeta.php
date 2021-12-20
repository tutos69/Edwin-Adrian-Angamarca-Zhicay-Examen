<?php include('../templates/header.php');

$txtNumero = (isset($_POST['txtNumero'])) ? $_POST['txtNumero'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtcvv = (isset($_POST['txtcvv'])) ? $_POST['txtcvv'] : "";
$txtFehca = (isset($_POST['txtFehca'])) ? $_POST['txtFehca'] : "";

$add = (isset($_POST['add'])) ? $_POST['add'] : "";
switch ($add) {
    case 'Agregar':
        $agregarTarjeta = "INSERT INTO tarjeta VALUES (0,'$txtNumero','$txtNombre','$txtcvv', '$txtFehca')";
        if ($coon->query($agregarTarjeta) == true) {
        } else {
            echo "No Vale" . mysqli_error($coon);
        }
        break;
}



?>

<link rel="stylesheet" href="../../css/bootstrap.min.css">

<div class="container">
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xl-3">

        </div>
        <div class="col-xl-6">
            <form method="POST">
                <h1>Ingrese Datos de la Tarjeta</h1>
                <label class="form-label mt-4">Nombre:</label>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="txtNombre" value="" placeholder="Fecha">
                    <label for="floatingInput">Nombre</label>
                </div>

                <label class="form-label mt-4">Numero De Tarjeta:</label>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="txtNumero" value="" placeholder="Fecha">
                    <label for="floatingInput">Numero De Tarjeta</label>
                </div>

                <label class="form-label mt-4">Fecha:</label>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" name="txtFehca" value="" placeholder="Fecha">
                    <label for="floatingInput">Fecha</label>
                </div>

                <label class="form-label mt-4">Codigo de Seguridad:</label>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="txtcvv" value="" placeholder="Fecha">
                    <label for="floatingInput">CVV</label>
                </div>
                <button type="submit" name="add" value="Agregar" class="btn btn-warning">Agregar</button>
            </form>
        </div>
    </div>
</div>




<?php include('../templates/footer.php'); ?>