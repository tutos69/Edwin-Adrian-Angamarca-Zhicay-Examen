<?php include('../templates/header.php');
$sentenciaSQL = "SELECT * FROM comida";
$add = (isset($_POST['add'])) ? $_POST['add'] : "";
$txtCodigo = (isset($_POST['txtCodigo'])) ? $_POST['txtCodigo'] : "";
$listado = $coon->query($sentenciaSQL);
if (isset($_POST['add'])) {
    if (isset($_SESSION['carro'])) {
        $item_array_id = array_column($_SESSION['carro'],"txtCodigo");
        if (in_array($_POST['txtCodigo'], $item_array_id)) {
            echo "<script>alert('Producto Ya esta en el Carrito')</script>";
            echo "<script>window.location = 'Productos.php'</script>";
        }else{
            $count = count($_SESSION['carro']);
            $item_array = array(
                'txtCodigo' => $_POST['txtCodigo'],
            
            );
            $_SESSION['carro'][$count]=$item_array;
        }
    } else {
        $item_array = array(
            'txtCodigo' => $_POST['txtCodigo']
        );
        $_SESSION['carro'][0] = $item_array;
        print_r($_SESSION['carro']);
    }
}
?>
<link rel="stylesheet" href="../../css/bootstrap.min.css">

<div class="row">
    <?php foreach ($listado as $restaurantes) { ?>

        <div class="col-md-4">
            <div class="card">
                <form action="" method="POST">
                    <img class="card-img-top" src="../../img/<?php echo $restaurantes['com_imagen']; ?>" alt="">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $restaurantes['com_nombre']; ?></h4>
                        <h4 class="card-title">$ <?php echo $restaurantes['com_presio']; ?></h4>
                        <input type="hidden" name="txtCodigo" id="txtCodigo" value="<?php echo $restaurantes['com_id']; ?>" />
                        <button type="submit" name="add" class="btn btn-warning">Agregar</button>
                    </div>
                </form>
            </div>
        </div>

    <?php } ?>
</div>

<?php include('../templates/footer.php'); ?>