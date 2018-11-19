<?php

session_start();
$filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'usuario' => FILTER_SANITIZE_STRING,
    'password' => FILTER_SANITIZE_STRING,
    'email' => FILTER_SANITIZE_EMAIL,
    'universidad' => FILTER_SANITIZE_STRING
);
$entradas = filter_input_array(INPUT_POST, $filtros); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */


$usuario = $entradas['usuario'];
$password = password_hash($entradas['password'], PASSWORD_DEFAULT);
$email = $entradas['email'];
$universidad = $entradas['universidad'];

if (isset($_SESSION["logFallido"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
    unset($_SESSION["logFallido"]);
}
if (isset($_SESSION["regFallido"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
    unset($_SESSION["regFallido"]);
}
//Comprobamos si es valido el correo
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $con = mysqli_connect("localhost", "root", "", "epd6p3");

    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }

//Hacemos una insercion en la base de datos, la fecha de registro es automatica
    $consulta = "INSERT INTO `usuarios` (`usuario`, `password`, `email`, `universidad`) VALUES ('$usuario', '$password', '$email','$universidad')";
    $resultado = mysqli_query($con, $consulta); //devuelve el resultado en caso de consulta, Verdadero en el resto de SQL si la ha realizado correctamente

    if ($resultado) {
        if(isset($_SESSION['regFallido'])){
            unset($_SESSION['regFallido']);
        }
        $_SESSION["regExito"] = TRUE;
        header("Location: index.php");
    } else {
        $_SESSION["regFallido"] = True; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver 
        header("Location: index.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
        exit();
    }

    mysqli_close($con); /* Cerramos la base de datos */
} else {
    $_SESSION['regFallido'] = "<br> Email no valido";
    header("Location: index.php");
}


