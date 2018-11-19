<!DOCTYPE html>
<!--
NOTA: PARA HACER INYECCION SQL USAR ' EN VEZ DE "
-->

<?php
session_start();
?>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1> Liga de Baloncesto Andaluza </h1>
        <h2> Login</h2>
        <nav>
            <a href="altaUsuario.php">Alta Usuario</a>
        </nav>

        <form action = "loginProcesamiento.php" method = "post">
            Usuario: <input type = "text" name = "username" required/><br />
            Password: <input type = "password" name = "password" required /> <br />
            <input type = "submit" value="Enviar" name = "login" />
        </form>
        <form action = "registro.php" method = "post">
            Si no esta registrado <input type="submit" value="Registrese" name="registro" /> <!--Boton que al pulsar te redirecciona a registro-->
        </form>
        <?php
//En vez de un html como ponia en la practica hemos introducido un php para poder avisar del error de logueo
        if (isset($_SESSION["fallido"])) {
            echo "Error al logearse";
        }
        if (isset($_SESSION["exito"])) {
            unset($_SESSION["exito"]);
            echo "Se ha registrado correctamente, pruebe a logearse con la cuenta creada";
        }
        ?>
        
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>
