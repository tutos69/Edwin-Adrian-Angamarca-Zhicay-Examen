<?php include('../templates/header.php'); ?>
<script src="../../js/buscart.js" type="text/javascript"> </script>
<link rel="stylesheet" href="../../css/bootstrap.min.css">
<section id="buscarT">
    <form id="Pedidos" onsubmit="return buscarTarjeta()">
        <br>
        <br>
        <div class="col-sm-10">
            <input type="text" id="tarjeta" class="form-control" aria-describedby="emailHelp" name="tarjeta" value="" placeholder="Ingrese el  numero de la Tarjeta">
        </div>
        <br>
        <br>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary" id="buscar" name="buscar" value="Buscar" onclick="buscarTarjeta()">Buscar</button>
        </div>
    </form>
</section>

<?php include('../templates/footer.php'); ?>