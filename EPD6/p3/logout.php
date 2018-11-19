<html>
    <head>
        <meta charset="UTF-8">
        <title>Logout</title>
    </head>
    <body>
        <?php
        session_start(); //Hay que llamar a session_start en cada pagina php que vayamos a querer trabajar con algo relacionado con la session actual
         
        unset($_SESSION["usuario"]);
        unset($_SESSION["regFallido"]);
        unset($_SESSION["logFallido"]);
       
        /* El redireccionamiento tambien se podria hacer
          header("Location: login.php"); pero de esta forma no podemos enviar echo al usuario, se ejecuta directamente */
        header("Location: index.php"); /* El refresh son los segundos que tardara en redireccionarnos, una ventaja del refresh esque rompe el boton de back
          y no dejar volver hacia atras ya que regarga el contenido de la pagina */
        echo 'Has limpiado sesion si no redirige el navegador pulsa <a href="index.php"> aqui <a>';
        ?>
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>