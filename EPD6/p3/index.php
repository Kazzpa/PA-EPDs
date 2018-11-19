<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>EPD6-P3</title>
    </head>
    <body>
        <form action="logout.php" method="post" > 
            <input type="submit" value="logout">
        </form>
        <?php
        session_start();
        //A MODIFICAR ARCHIVOS->SQL
        // guardarUsuario ,BUSCAARCHIVO,BUSCAARCHIVOUNI, guardararchivo,
        //listar usuarios listarArchivos, isregistered isuploaded, uniUsuario
        //NOTA SI SE EXCEDE EL LIMITE DE 8M DE ENVIO POR POST SALTARA UNA EXCEPCION
        //SE ARREGLA MODIFICANDO LA CONFIGURACION DE post_max_size
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
            echo '<br>Login :<br><form action="loginProcesamiento.php" method="post">'
            . 'usuario:<input type = "text"name="usuario" value="usuario"> '
            . 'password:<input type = "password" name = "password">'
            . '<input type = "submit" name = "log" value = "ok">'
            . '</form>';
        }

        function formRegister($universidades) {
            echo'<br>Registro :<br><form action = "registroProcesamiento.php" method = "post">'
            . 'usuario:<input type = "text" name = "usuario" >'
            . ' password:<input type = "password" name = "password">'
            . 'email : <input type = "text" name = "email">'
            . 'Universidad: <select name = "universidad">';
            for ($i = 0; $i < sizeof($universidades); $i++) {
                echo '<option value = "' . $universidades[$i][0] . '">' .
                $universidades[$i][1] . '</option>';
            }
            echo '</select>'
            . '<input type = "submit" name = "reg" value = "ok">'
            . '</form>';
        }

        function formUpload($limite) {
            echo'<form action="uploadProcesamiento.php" method="post" enctype="multipart/form-data">'
            . '<input type="hidden" name="MAX_FILE_SIZE" value="' . $limite .
            '" />Selecciona el PDF a subir, maximum size: 5MB.
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
            echo '<br>Busque articulos con una palabra caracteristica'
            . '<form action="busquedaProcesamiento.php" method="post">'
            . 'Palabra: <input type="text" name="buscar">'
            . '<input type="submit" value="Buscar" name="Busqueda"></form>';
        }

        function formBusquedauni($universidades) {
            echo '<br>Busque articulos de una universidad'
            . '<form action="busquedaProcesamiento.php" method="post">';
            echo 'Universidad: <select name = "buscarUni">';
            for ($i = 0; $i < sizeof($universidades); $i++) {
                echo '<option value = "' . $universidades[$i][0] . '">' .
                $universidades[$i][1] . '</option>';
            }
            echo '</select>'
            . '<input type="submit" value="Buscar" name="busUni"></form>';
        }

        
        function listarArchivos($usuario) {

            $bol = False;
            $con = mysqli_connect("localhost", "root", "", "epd6p3");
            if (!$con) {
                die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
            }
            $consulta = "SELECT * FROM archivos WHERE usuario = '$usuario'";
            $resultado = mysqli_query($con, $consulta);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                $str[] = $fila['nombre'];
                $bol = True;
            }
            if (!$bol) {
                $str = False;
            }
            return $str;
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
        //LOG FALLIDO
        if (isset($_SESSION['logFallido'])) {
            unset($_SESSION['logFallido']);
            echo "<br>Log Fallido";
            formLog();
            formRegister($universidades);
            //LOGADO
        } else if (isset($_SESSION['usuario'])) {
            $usuario = $_SESSION['usuario'];
            formDownload($usuario);
            formUpload($limite);
            if (isset($_SESSION['upExito'])) {
                unset($_SESSION['upExito']);
            } else if (isset($_POST['archivo'])) {
                $fichero = $_POST['archivo'];
                descargarArchivo($fichero);
            }
        } else if (isset($_SESSION['regExito'])) {
            unset($_SESSION['regExito']);
            echo "registro correcto";
            formLog();
        } else if (isset($_SESSION['regFallido'])) {
            echo "<br>Reg Fallido";
            unset($_SESSION['regFallido']);
            formRegister($universidades);
        } else {
            echo "<br>Por defecto usuario valido de prueba: paco pass:12";
            formLog();
        }
        
        if (isset($_SESSION['buscarExito'])) {
            $archivos = $_SESSION['buscarExito'];
            imprimirArchivos($archivos);
            unset($_SESSION['buscarExito']);
        } else if (isset($_SESSION['bUniExito'])) {
            $archivos = $_SESSION['bUniExito'];
            imprimirArchivos($archivos);
            unset($_SESSION['bUniExito']);
        } else if (isset($_SESSION['bUniFallido']) || isset($_SESSION['buscarFallido'])) {
            unset($_SESSION['bUniFallido']);
            unset($_SESSION['buscarFallido']);
        }
            formBusquedauni($universidades);
            formBusqueda();
        
        ?>
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>
