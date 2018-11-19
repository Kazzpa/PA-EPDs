<?php

session_start();
$filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'nombre' => FILTER_SANITIZE_STRING,
    'password' => FILTER_SANITIZE_STRING,
    'username' => FILTER_SANITIZE_STRING
);
$entradas = filter_input_array(INPUT_POST, $filtros); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

$nombre = $entradas['nombre']; //Rescatamos todas las variables del formulario y les hacemos un saneamiento
$usuario = $entradas['username'];
$password = password_hash($entradas['password'], PASSWORD_DEFAULT );

$con = mysqli_connect("localhost", "root", "", "epd6");

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

//Hacemos una insercion en la base de datos, la fecha de registro es automatica
$consulta = "INSERT INTO `usuarios` (`nombre_persona`, `nombre_usuario`, `password`, `f_registro`) VALUES ('$nombre', '$usuario', '$password', CURRENT_TIMESTAMP)";
$resultado = mysqli_query($con, $consulta); //devuelve el resultado en caso de consulta, Verdadero en el resto de SQL si la ha realizado correctamente

if ($resultado) {
    if (isset($_SESSION["rechazado"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
        unset($_SESSION["rechazado"]);
    }
    $_SESSION["exito"] = TRUE;
    header("Location: login.php");
} else {
    $_SESSION["rechazado"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver 
    header("Location: registro.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}

/* $_SESSION['usuarioIdentificado'] = $fila['usuario']; levantar una sesion, se mantiene hasta que lo cierres 
  unset($_SESSION['usuarioIdentificado']); Cerrar sesion */

mysqli_close($con); /* Cerramos la base de datos */

