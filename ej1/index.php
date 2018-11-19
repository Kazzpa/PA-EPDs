<?php
session_start(); /* Las cookies y session (basada en cookies) se deben crear antes de crear mostrar cualquier salida al navegador
  Vamos a trabajar con session en este problema porque estan ocultos al usuario almacenandose del lado del servido. Usando cookies que se almacenan
  del lado del cliente le dejariamos lugar a que cambiara su usuario o su contraseña (que es lo que vamos a almacenar) y eso podria dar lugar
  a fallas de seguridad. Ahora se crea la variable super global $_SESSION que actua como un vector asociativo. Además una diferencia importante esque las
  cookies se almacenan en el ordenador y la sesion se va cuando se cierra el navegador */
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>EPD6-EJ1</title>
    </head>
    <body>       
        <h1> Liga de Baloncesto Andaluza</h1>
        <nav>
            <a href="altaUsuario.php">Alta Usuario</a>
        </nav> 
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>