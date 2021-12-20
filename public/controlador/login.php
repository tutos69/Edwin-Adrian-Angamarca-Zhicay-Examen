
    <?php
    $alerta = '';
    session_start();
    if (!empty($_SESSION['activate'])) {
        header('Location:../../administrador/index.php');
    } else {

        if (!empty($_POST)) {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $alerta = "Ingrese Su Correo Y contraceña";
            } else {
                include '../../administrador/config/conexion.php';

                $user = $_POST['email'];
                $pass = $_POST['password'];
                $sql = mysqli_query($coon, "SELECT * FROM usuario WHERE usu_correo = '$user' AND usu_contracenia = md5('$pass')");
                $result = mysqli_num_rows($sql);
                if ($result > 0) {
                    $data = mysqli_fetch_array($sql);

                    $_SESSION['activate'] = true;
                    $_SESSION['idUsuario'] = $data['usu_id'];
                    header('Location:../../administrador/index.php');
                } else {
                    $alerta = 'El Usuario Esta mal ingresado';
                    header('Location:../../index.php');
                    session_destroy();
                }
            }
        }
        $coon->close();
    }
    ?>