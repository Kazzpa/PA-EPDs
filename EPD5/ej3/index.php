<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 1</title>
        <style>
            .error{
                color:red
            }
        </style>
    </head>
    <body>       
        <h1> Da a conocer tu ruta de senderismo </h1>


        <?php

        function form() {
            echo '  <form action="#" method="post">       
            Nombre completo: <input name="nombre" type="text" ';
            if (isset($_POST['nombre'])) {
                echo 'value = "' . $_POST['nombre'] . '"';
            }echo'required/> <br />
            Correo Electronico: <input name="email" type="text" ';
            if (isset($_POST['email'])) {
                echo 'value = "' . $_POST['email'] . '"';
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo 'class ="error" required/>';
                    echo "Formato de email incorrecto ej: user@domain.com";
                } else {
                    echo "required/>";
                }
            } else {
                echo "required/>";
            }
            echo'<br />
            Usuario Twitter: <input name="twitterUser" type="text" ';
            if (isset($_POST['twitterUser'])) {
                echo 'value = "' . $_POST['twitterUser'] . '"';
                $twitterUser = $_POST['twitterUser'];
                $ret = compruebaTwitter($twitterUser);
                if ($ret > 0) {
                    echo 'class = "error" required/>';
                    imprimeErrorTw($ret);
                } else {
                    echo "required/>";
                }
            } else {
                echo "required/>";
            }
            echo'<br />
            Numero Fijo: <input name="fijo" type="tel" ';
            if (isset($_POST['fijo'])) {
                echo 'value = "' . $_POST['fijo'] . '"';
                $fijo = $_POST['fijo'];
                $ret = compruebaNumero($fijo, "9");
                if ($ret != 0) {
                    echo 'class = "error"';
                }
                echo 'required/>';
                imprimeErrorNum($ret, True);
            } else {
                echo 'required/>';
            }
            echo' <br />
            Numero Movil: <input name="movil" type="tel" ';
            if (isset($_POST['movil'])) {
                echo 'value = "' . $_POST['movil'] . '"';
                $movil = $_POST['movil'];
                $ret = compruebaNumero($movil, "6");
                if ($ret != 0) {
                    echo 'class = "error"';
                }
                echo 'required/>';
                imprimeErrorNum($ret, False);
            } else {

                echo 'required/>';
            }
            echo'<br />
            Provincia: <select name="provincia" ';
            if (isset($_POST['provincia'])) {
                echo 'value = "' . $_POST['provincia'] . '"';
            }
            echo'required>
                <option value="Sevilla">Sevilla</option>
                <option value="Cadiz">Cadiz</option>
                <option value="Cordoba">Cordoba</option>
                <option value="Jaen">Jaen</option>
                <option value="Granada">Granada</option>
                <option value="Almeria">Almeria</option>
                <option value="Malaga">Malaga</option>
                <option value="Huelva">Huelva</option>
            </select><br />
            <p>Información sobre la ruta:</p>
            <textarea name="informacion" cols="60" rows="20" required>';
            if (isset($_POST['informacion'])) {
                echo $_POST['informacion'];
            }
            echo'</textarea> <br />
            <input type="submit" name="envio" value="Enviar" required/>
            <input type="reset" name="rest" value="Restaurar" required/>
        </form>';
        }

        function compruebaTwitter($twitterUser) {
            $bol = 0;
            $r = strpos($twitterUser, "@");
            if ($r !== False) {
                if ($r != 0) {
                    $bol = 2;
                }
            } else {
                $bol = 1;
            }
            return $bol;
        }

        function compruebaNumero($numero, $digito) {
            $int = 0;
            if (filter_var($numero, FILTER_VALIDATE_INT)) {
                if (strlen((string) $numero) == 9) {
                    $r = strpos($numero, $digito);
                    if ($r !== False) {
                        if ($r != 0) {
                            $int = 3;
                        }
                    } else {
                        $int = 3;
                    }
                } else {
                    $int = 2;
                }
            } else {
                $int = 1;
            }

            return $int;
        }

        function imprimeErrorNum($int, $esFijo) {

            if ($int > 0) {
                switch ($int) {
                    case 1:
                        echo "Introduzca un numero valido ej:";
                        break;
                    case 2:
                        echo "Introduzca 9 digitos ej:";
                        break;
                    case 3:
                        echo "El primer digito debe ser un 9 ej:";
                        break;
                }
                if ($esFijo) {
                    echo " 934125827";
                } else {
                    echo " 612928317";
                }
            }
        }

        function imprimeErrorTw($int) {
            if ($int > 0) {
                switch ($int) {
                    case 1:
                        echo "No hay un @ ej:";
                        break;
                    case 2:
                        echo "el @ debe estar al principio ej:";
                        break;
                }
                echo " @user";
            }
        }

        if (filter_has_var(INPUT_POST, 'envio')) {
            //Comprobar campos enviados
            if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['twitterUser']) && isset($_POST['fijo']) && isset($_POST['movil']) && isset($_POST['provincia']) && isset($_POST['informacion'])) {
                $bol = True;
                $nombre = $_POST['nombre'];
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $bol = False;
                }
                $twitterUser = $_POST['twitterUser'];
                if (!compruebaTwitter($twitterUser) ==0) {
                    $bol = False;
                }
                $fijo = $_POST['fijo'];
                if (!compruebaNumero($fijo, "9") == 0) {
                    $bol = False;
                }
                $movil = $_POST['movil'];
                if (!compruebaNumero($movil, "6") == 0) {
                    $bol = False;
                }
                $provincia = $_POST['provincia'];
                $informacion = $_POST['informacion'];
                if (!$bol) {
                    form();
                } else {
                    echo 'Gracias por participar, la información enviada es la siguiente: <br />';
                    echo "Nombre: $nombre <br />";
                    echo "Email: $email <br />";
                    echo "Usuario Twitter: $twitterUser <br />";
                    echo "Fijo: $fijo <br />";
                    echo "Movil: $movil <br />";
                    echo "Provincia: $provincia <br />";
                    echo "Información: $informacion <br />";
                }
            } else {
                form();
            }
        } else {
            form();
        }
        ?>

        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andres Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>