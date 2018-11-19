<?php
session_start();
function buscaArchivos($palabra) {
    $bol = False;
    $con = mysqli_connect("localhost", "root", "", "epd6p3");
    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }
    $consulta = "SELECT * FROM archivos WHERE descripcion LIKE '%$palabra%'";
    $resultado = mysqli_query($con, $consulta);
    $i = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $bol = True;
        $ret[$i][0] = $fila['nombre'];
        $ret[$i][1] = $fila['usuario'];
        $ret[$i][2] = $fila['universidad'];
        $i++;
    }
    if (!$bol) {
        $ret = False;
    }
    mysqli_close($con);
    return $ret;
}

function buscaArchivosUni($uni) {
    $bol = False;
    $con = mysqli_connect("localhost", "root", "", "epd6p3");
    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }
    $consulta = "SELECT * FROM archivos WHERE universidad = '$uni'";
    $resultado = mysqli_query($con, $consulta);
    $i = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $bol = True;
        $ret[$i][0] = $fila['nombre'];
        $ret[$i][1] = $fila['usuario'];
        $ret[$i][2] = $fila['universidad'];
        $i++;
    }
    if (!$bol) {
        $ret = False;
    }
    mysqli_close($con);
    return $ret;
}
$filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'buscar' => FILTER_SANITIZE_STRING,
    'buscarUni' => FILTER_SANITIZE_STRING
    
);
///////------MAIN--------
$entradas = filter_input_array(INPUT_POST, $filtros); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

print_r($_POST);
if (isset($_POST['buscar'])) {
    echo "buscar";
    $palabra = $entradas['buscar'];
    $archivos = buscaArchivos($palabra);
    if ($archivos) {
        echo "<br>encontrado archivos";
        if (isset($_SESSION['buscarFallido'])){
            unset($_SESSION['buscarFallido']);
        }
        $_SESSION['buscarExito'] = $archivos;
        header("Location: index.php", true, 301);
    } else {
        echo "<br>no encontrado archivos";
        $_SESSION['buscarFallido'] = True;
        header("Location: index.php", true, 301);
    }
} else if (isset($entradas['buscarUni'])) {
    echo "uni";
    $uni = $entradas['buscarUni'];
    $archivos = buscaArchivosUni($uni);
    print_r($archivos);
    if ($archivos) {
        echo "<br>encontrado archivos";
        if (isset($_SESSION['bUniFallido'])) {
            unset($_SESSION['bUniFallido']);
        }
        $_SESSION['bUniExito'] = $archivos;
        header("Location: index.php", true, 301);
    } else {
        echo "<br>no encontrado archivos";
        $_SESSION['bUniFallido'] = True;
        header("Location: index.php", true, 301);
    }
}
//header("Location: index.php", true, 301); /* Redireccionamos al usuario a la pagina de login, debe ser usada antes que cualquier output */
exit();
