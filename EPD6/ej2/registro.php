<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();
?>

<html>
    <head>
        <title>Registro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1> Liga de Baloncesto Andaluza </h1>
        <h2> Registro</h2>
        <nav>
            <a href="altaUsuario.php">Alta Usuario</a>
        </nav> 
        <form action = "registroProcesamiento.php" method = "post">
            Nombre: <input type = "text" name = "nombre" required/><br />
            Usuario: <input type = "text" name = "username" required/><br />
            Password: <input type = "password" name = "password" required /><br />
            <input type = "submit" value="Registro" name = "registroProcesamiento" />
        </form>

        <?php
        if (isset($_SESSION["rechazado"])) {
            echo "Error al registrarse, es posible que el usuario que intenta crear ya exista";
        }
        ?>
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>
