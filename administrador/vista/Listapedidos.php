<?php include('../templates/header.php'); ?>
<script src="../../js/buscarP.js" type="text/javascript"> </script>
<link rel="stylesheet" href="../../css/bootstrap.min.css">

<section id="listaPedidos">
        <form id="listado" onsubmit="return buscarPedido()">
            <br>
            <br>
            <div class="col-sm-10">
                <input type="text" id="numero" class="form-control" aria-describedby="emailHelp" name="numero" value=""
                    placeholder="Ingrese el  numero de la Tarjeta">
            </div>
            <br>
            <br>
            <div class="col-sm-10">
                <input type="text" id="nombre" class="form-control" aria-describedby="emailHelp" name="nombre" value=""
                    placeholder="Ingrese el  nombre de la comida">
            </div>
            <br>
            <br>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" id="buscar" name="buscar" value="Buscar"
                    onclick="buscarPedido()">Buscar</button>
            </div>

        </form>
    </section>

<?php include('../templates/footer.php'); ?>