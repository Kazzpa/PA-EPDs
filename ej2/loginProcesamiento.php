<html>

    <head>
        <meta charset="UTF-8">
        <title>LoginProcesamiento</title>
    </head>
</html>
<?php
session_start();

if (isset($_POST['registro'])) {
    header("Location: registro.html", true, 301); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}

$filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'password' => FILTER_SANITIZE_STRING,
    'username' => FILTER_SANITIZE_STRING
);

$entradas = filter_input_array(INPUT_POST, $filtros); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

$usuario = $entradas['username']; //Rescatamos todas las variables del formulario y les hacemos un saneamiento
$password = $entradas['password'];
$con = mysqli_connect("localhost", "root", "", "epd6"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

$consulta = "SELECT * FROM usuarios WHERE nombre_usuario = '$usuario' AND password = '$password'"; //consulta SQL para obtener el usuario y la password
$resultado = mysqli_query($con, $consulta);
$fila = mysqli_fetch_assoc($resultado);


if ($fila) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
    $_SESSION['username'] = $usuario; //Creamos la clave asociativa, asi ya sabemos que el usuario esta logueado
    $_SESSION['password'] = $password;
    $_SESSION['f_registro'] = $fila['f_registro'];
    if (isset($_SESSION["fallido"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
        unset($_SESSION["fallido"]);
    }
    $paginaWeb = $_SESSION['webRedirect'];
    header("Location: $paginaWeb", true, 301); /* Redireccionamos al usuario a la pagina de login, debe ser usada antes que cualquier output */
    exit(); /* Debemos terminar el script porque el script de la pagina no se sigue ejecutando tras usar header */
    //Devolvemos al usuario a la pagina en la que se encontraba previo al login
} else {
    $_SESSION["fallido"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver 
    header("Location: login.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}
mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
