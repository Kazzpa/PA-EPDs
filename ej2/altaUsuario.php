<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>altaEquipo</title>
    </head>
    <body>
        <?php
        session_start();

        function login() { //Funcion de login
            $_SESSION['webRedirect'] = basename($_SERVER['PHP_SELF']); /* Esta funcion devuelve la pagina PHP actual, podriamos hacerlo a mano(altaEquipo.php) pero asi es mas generica
              Guardamos la pagina desde la que viene el usuario en la sesion para posteriormente devolverle a esta misma
             */
            header('Location:login.php', true, 301); /* Redireccionamos al usuario a la pagina de login, debe ser usada antes que cualquier output */
            exit(); /* Debemos terminar el script porque el script de la pagina no se sigue ejecutando tras usar header */
        }

        function mostrarformulario() { //Formulario a mostrar
            $username = $_SESSION['username'];
            $f_registro = $_SESSION['f_registro'];
            echo "
        <h1> Liga de Baloncesto Andaluza </h1>
        <h2> Alta Usuario</h2>
        Bienvenido $username registrado: $f_registro
        <nav>
             <a href='logout.php'>Logout<a>
        </nav> <br />
        
    </body>";
        }
        ?>


        <?php
        if (isset($_SESSION['username']) && isset($_SESSION['password'])) { /* Si el usuario se encuentra logado en el sistema entonces permitimos al usuario dar de alta un equipo */
            /* Accedemos una vez se haya enviado el formulario */
            mostrarFormulario();
        } else { /* Si no se encuentra logado entonces le mostramos la pantalla de login */
            login();
            /* ob_start(); //Iniciamos un buffer para el loggin, la informacion que se muestre a partir de aqui se borrara posteriormente al hacer la recarga de la pagina
              echo 'a';
              print 'b'; // some statement that removes all printed/echoed items
              ob_end_clean(); //Limpiamos el buffer y eliminamos toda la informacion */
        }
        ?>
        
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>