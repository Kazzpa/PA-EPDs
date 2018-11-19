<?php

session_start();

$limite = 5 * 1024 * 1024; // 5GB

function soloPDF($archivo) {
    $bool = False;
    if (isset($archivo)) {
        if ($archivo["type"] == "application/pdf") {
            $bool = True;
        }
    }
    return $bool;
}

function limiteTamanyo($archivo, $limite) {
    $bool = False;
    if (isset($archivo)) {
        if ($archivo["size"] <= $limite) {
            $bool = True;
        }
    }
    return $bool;
}

function uniUsuario($usuario) {
    $ret = "";
    $con = mysqli_connect("localhost", "root", "", "epd6p3");
    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }
    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($con, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $ret = $fila['universidad'];
    }
    mysqli_close($con);
    return $ret;
}

function isUploaded($archivo) {
    $hash = md5_file($archivo['tmp_name']);
    $bol = False;
    $con = mysqli_connect("localhost", "root", "", "epd6p3");
    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }
    $consulta = "SELECT * FROM archivos WHERE hash = '$hash'";
    $resultado = mysqli_query($con, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $bol = True;
    }
    mysqli_close($con);
    return $bol;
}

function saveToDisk($archivo) {
    $bol = False;
    if (move_uploaded_file($archivo['tmp_name'], $archivo['name'])) {
        $bol = True;
    }
    return $bol;
}

function guardarArchivo($usuario, $archivo, $desc, $uni) {
    $con = mysqli_connect("localhost", "root", "", "epd6p3");

    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }
    echo $archivo['tmp_name'];
    $hash = md5_file($archivo['name']);
    $fecha = date("Y-m-d");
//Hacemos una insercion en la base de datos, la fecha de registro es automatica
    $consulta = "INSERT INTO `archivos` (`nombre`, `fecha`, `descripcion`, `usuario`,`universidad`,`hash`)"
            . " VALUES ('" . $archivo['name'] . "', '$fecha', '$desc','$usuario','$uni','$hash')";
    $resultado = mysqli_query($con, $consulta);
    if (!$resultado) {
        $_SESSION['upFallido'] = True;
    }
    mysqli_close($con);
}

$filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'descripcion' => FILTER_SANITIZE_STRING
);
$entradas = filter_input_array(INPUT_POST, $filtros); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

$usuario = $_SESSION['usuario'];
$archivo = $_FILES['archivo'];
$desc = $entradas['descripcion'];
$valido = True;
print_r($_FILES);
if ($archivo["error"] > 0) {
    $valido = False;
} else if (!soloPDF($archivo)) {
    $valido = False;
} else if (!limiteTamanyo($archivo, $limite)) {
    $valido = False;
} else if (isUploaded($archivo)) {
    $valido = False;
} else if (saveToDisk($archivo)) {
    guardarArchivo($usuario, $archivo, $desc, uniUsuario($usuario));
}
if ($valido) {
    if (isset($_SESSION['upFallido'])) {
        unset($_SESSION['upFallido']);
    }
    $_SESSION['upExito'] = True;
    header("Location: index.php", true, 301);
    exit();
} else {
    $_SESSION['upFallido'] = True;
    header("Location: index.php", true, 301);
    exit();
}