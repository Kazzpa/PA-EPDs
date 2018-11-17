<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //Variables para reconocer las universidades
        $universidades = array(
            array("UAL", "Universidad de Almería"),
            array("UCA", "Universidad de Cádiz"),
            array("UCO", "Universidad de Córdoba"),
            array("UGR", "Universidad de Granada"),
            array("UHU", "Universidad de Huelva"),
            array("UJAEN", "Universidad de Jaén"),
            array("UMA", "Universidad de Málaga"),
            array("US", "Universidad de Sevilla"),
            array("UNIA", "Universidad Internacional de Andalucía"),
            array("UPO", "Universidad Pablo de Olavide"),
        );
        $limite = 5 * 1024 * 1024; // 5GB
        //funciones
        function formLog() {
            echo '<br>Login :<br><form action="" method="post">'
            . 'usuario:<input type = "text"name="usuario" value="usuario"> '
            . 'password:<input type = "password" name = "password">'
            . '<input type = "submit" name = "log" value = "ok">'
            . '</form>';
        }

        function formRegister($universidades) {
            echo'<br>Registro :<br><form action = "" method = "post">'
            . 'usuario:<input type = "text" name = "usuario" value = "';
            if (isset($_POST['usuario'])) {
                echo $_POST['usuario'];
            }
            echo '">' .
            ' password:<input type = "password" name = "password" value = "';
            if (isset($_POST['pass'])) {
                echo $_POST['pass'];
            }
            echo '">email : <input type = "text" name = "email" value = "';
            if (isset($_POST['email']))
                echo $_POST['email'];
            echo '">Universidad: <select name = "universidad"';
            if (isset($_POST['universidad'])) {
                echo 'value = "' . $_POST['universidad'] . '"';
            }
            echo '>';
            for ($i = 0; $i < sizeof($universidades); $i++) {
                echo '<option value = "' . $universidades[$i][0] . '">' .
                $universidades[$i][1] . '</option>';
            }
            echo '</select>'
            . '<input type = "submit" name = "reg" value = "ok">'
            . '</form>';
        }

        function formUpload() {
            echo'<form action="" method="post" enctype="multipart/form-data">';
            if (isset($_POST['log'])) {
                echo '<input type="hidden" name="usuario" value="' .
                $_POST['usuario'] . '">';
            }
            echo'Selecciona el PDF a subir, maximum size: 5MB.
            <input type="file" name="archivo" id="archivo">
            Escriba una descripción del PDF
            <input type="text" name="descripcion" >
            <input type="submit" value="Upload" name="upload">
            </form>';
        }

        function formDownload($usuario) {

            $r = listarArchivos($usuario);

            if (!empty($r)) {
                echo'<br>Seleccione el archivo a descargar' .
                ' para el usuario ' . $usuario;
                echo'<form name="download" action ="" method="post"><select name="archivo">';
                for ($i = 0; $i < sizeof($r); $i++) {
                    echo '<option value ="';
                    echo $r[$i];
                    echo'">' . $r[$i] . ' </option>';
                }
                echo'</select><input type="submit" name="download" value="Descargar"></form>';
            } else {
                echo '<br>Este usuario no tiene archivos disponibles';
            }
        }

        function formBusqueda() {
            echo '<br>Busque articulos con una palabra caracteristica<form'
            . ' action="" method="post">Palabra: <input type="text" name="buscar">'
            . '<input type="submit" value="Buscar" name="Busqueda"></form>';
        }

        function formBusquedauni($universidades) {
            echo '<br>Busque articulos de una universidad<form'
            . ' action="" method="post">';
            echo 'Universidad: <select name = "buscarUni">';
            for ($i = 0; $i < sizeof($universidades); $i++) {
                echo '<option value = "' . $universidades[$i][0] . '">' .
                $universidades[$i][1] . '</option>';
            }
            echo '</select>'
            . '<input type="submit" value="Buscar" name="busUni"></form>';
        }

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

        function guardarUsuario($usuario, $password, $email, $uni) {
            $f = fopen("usuarios.csv", 'a');
            if ($f) {
                flock($f, LOCK_EX);
                $fila = $usuario . ';' . $password . ';' . $email . ';'
                        . $uni . "\n";
                fwrite($f, $fila);
                flock($f, LOCK_UN);
                fclose($f);
            }
        }

        function guardarArchivo($usuario, $archivo, $desc, $uni) {
            $f = fopen("archivos.csv", 'a');

            $hash = md5_file($archivo['name']);
            $fecha = date("H:i");
            if ($f) {
                flock($f, LOCK_EX);
                $fila = $archivo["name"] . ";" . $fecha . ";" . $desc . ";" .
                        $usuario . ";" . $uni . ";" . $hash . "\n";
                fwrite($f, $fila);
                flock($f, LOCK_UN);
                fclose($f);
            }
        }

        function listarUsuario() {
            $f = fopen("usuarios.csv", 'r');
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f)) {

                    echo "<br>" . $fila[0] . " " . $fila[1] . " " .
                    $fila[2] . " " . $fila[3];
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
        }

        function listarArchivos($usuario) {
            $f = fopen("archivos.csv", 'r');
            $bol = False;
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f)) {
                    if ($fila[3] == $usuario) {
                        $str[] = $fila[0];
                        $bol = True;
                    }
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
            if (!$bol) {
                $str = False;
            }
            return $str;
        }

        function isRegistered($usuario, $password) {
            $reg = 0;
            $f = fopen("usuarios.csv", 'r');
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f) && $reg == 0) {
                    if ($fila[0] == $usuario) {
                        $reg = 1;
                        if ($fila[1] == $password) {
                            $reg = 2;
                        }
                    }
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }

            return $reg;
        }

        function isUploaded($archivo) {
            $bool = False;
            $f = fopen("archivos.csv", 'r');
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f) && !$bool) {
                    if ($fila[5] == md5_file($archivo['name'])) {
                        $bool = True;
                    }
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }

            return $bool;
        }

        function uniUsuario($usuario) {
            $f = fopen("usuarios.csv", 'r');
            $bol = False;
            $ret = "";
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f) && !$bol) {

                    if ($fila[0] == $usuario) {
                        $bol = True;
                        $ret = $fila[3];
                    }
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
            return $ret;
        }

        function buscaArchivosUni($uni) {
            $f = fopen("archivos.csv", 'r');
            $bol = False;
            $i = 0;
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f)) {
                    //Comprueba que no sea Falso, comprobamos por identidad
                    if (strpos($fila[4], $uni) !== False) {
                        $bol = True;
                        $ret[$i][0] = $fila[0];
                        $ret[$i][1] = $fila[3];
                        $ret[$i][2] = $fila[4];
                        $i++;
                    }
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
            if (!$bol) {
                $ret = False;
            }
            return $ret;
        }

        function buscaArchivos($palabra) {
            $f = fopen("archivos.csv", 'r');
            $bol = False;
            $i = 0;
            if ($f) {
                flock($f, LOCK_SH);
                $fila = fgetcsv($f, 999, ";");
                while (!feof($f)) {
                    if (strpos($fila[2], $palabra) !== False) {
                        $bol = True;
                        $ret[$i][0] = $fila[0];
                        $ret[$i][1] = $fila[3];
                        $ret[$i][2] = $fila[4];
                        $i++;
                    }
                    $fila = fgetcsv($f, 999, ";");
                }
                flock($f, LOCK_UN);
                fclose($f);
            }
            if (!$bol) {
                $ret = False;
            }
            return $ret;
        }

        function imprimirArchivos($archivos) {
            echo'<br><table>'
            . '<tr><th>Archivo</th> <th>Usuario</th> <th>Universidad</th></tr>';
            for ($i = 0; $i < sizeof($archivos); $i++) {
                echo '<tr><td>' . $archivos[$i][0]
                . '<td>' . $archivos[$i][1]
                . '<td>' . $archivos[$i][2] . '</tr>';
            }
            echo'</table>';
        }

        function descargarArchivo($fichero) {
            if (file_exists($fichero)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . basename($fichero) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fichero));
                readfile($fichero);
                exit;
            }
        }

        //----------------------MAIN-------------------------
        //Formulario log
        if (isset($_POST['log']) && !isset($_POST['download']) && !isset($_POST['reg']) && !isset($_POST['upload'])) {

            if (isset($_POST['usuario']) && isset($_POST['password'])) {
                $usuario = $_POST['usuario'];
                $password = $_POST['password'];

                $archivos = isRegistered($usuario, $password);
                if ($archivos == 2) {
                    echo "<br>Logeado"
                    . "<br>Bienvenido " . $usuario;
                    formUpload();
                    formDownload($usuario);
                } else if ($archivos == 1) {//usuario registrado contraseña erronea
                    echo'<br>Login incorrecto';
                    formLog();
                } else {//Usuario no encontrado en el sistema -> Registrar
                    formRegister($universidades);
                }
            } else {//Login incorrecto
                formLog();
            }
            //formulario registro
        } else if (isset($_POST['reg']) && !isset($_POST['upload']) && !isset($_POST['download'])) {

            //Comprobar si se han mandado todos los campos
            if (isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['universidad']) && isset($_POST['email'])) {
                $usuario = $_POST['usuario'];
                $password = $_POST['password'];
                $universidad = $_POST['universidad'];
                $email = $_POST['email'];
                //Validar campos

                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $archivos = isRegistered($usuario, $password);
                    if ($archivos != 0) {
                        echo'<br>Seleccione otro usuario';
                        formRegister($universidades);
                    } else {
                        guardarUsuario($usuario, $password, $email, $universidad);
                        echo '<br>Registrado en el sistema';
                        formLog();
                    }
                } else {
                    echo'<br>Formato de email incorrecto';
                    formRegister($universidades);
                }
            } else {
                formRegister($universidades);
            }
            //Formulario upload
        } else if (isset($_POST['upload']) && !isset($_POST['download'])) {
            //comprobar campos rellenos
            if (isset($_POST['usuario']) && isset($_FILES['archivo']) && isset($_POST['descripcion'])) {
                $archivo = $_FILES['archivo'];
                $desc = $_POST['descripcion'];
                $usuario = $_POST['usuario'];
                //validar campos
                if ($_FILES['archivo']["error"] > 0) {
                    echo "<br>error al enviar archivo";
                    formUpload();
                    formDownload($usuario);
                } else if (!soloPDF($archivo)) {
                    echo '<br>NO es un archivo PDF';
                    formUpload();
                    formDownload($usuario);
                } else if (!limiteTamanyo($archivo, $limite)) {
                    echo "<br> Fichero no valido";
                    formUpload();
                    formDownload($usuario);
                } else if (isUploaded($archivo)) {
                    echo "<br>archivo ya en sistema";
                    formUpload();
                    formDownload($usuario);
                } else {
                    echo "<br> Archivo Guardado: " . $archivo['name'];
                    guardarArchivo($usuario, $archivo, $desc, uniUsuario($usuario));
                }
            } else {
                echo " <br>no enviado completo";
                formUpload();
            }
            //Formulario descarga
        } else if (isset($_POST['archivo'])) {
            echo '<br>descargar ' . $_POST['archivo'];
            $fichero = $_POST['archivo'];
            descargarArchivo($fichero);
        } else {//No se ha envaiado nada->pagina por defecto
            //para poder usar la aplicacion
            echo 'Usuario ya registrado en sistema: paco contraseña: 12';
            formLog();
        }
        //Comprobacion de formulario de busqueda paralelo a los demas.
        if (isset($_POST['buscar'])) {
            $palabra = $_POST['buscar'];
            $archivos = buscaArchivos($palabra);
            if ($archivos) {
                imprimirArchivos($archivos);
            } else {
                echo'<br> no se encontraron articulos con: '.$palabra;
                formBusqueda();
                formBusquedauni($universidades);
            }
        } else if (isset($_POST['buscarUni'])) {
            $uni = $_POST['buscarUni'];
            $archivos = buscaArchivosUni($uni);
            if ($archivos) {
                imprimirArchivos($archivos);
            } else {
                echo'<br> no se encontraron articulos de: '.$uni;
                formBusqueda();
                formBusquedauni($universidades);
            }
        } else {
            formBusqueda();
            formBusquedauni($universidades);
        }
        ?>
    </body>
</html>
