<html>
    <head>
        <title>EPD8-Ex2</title>
        <script type="text/javascript">
            <!--
            function isEmpty(campo) {
                return (campo == "");
            }
            function check() {
                //Si el id no es correcto devolvera undefined como error
                var text = document.getElementById("idnombre").value;

                var clave = document.getElementById("idclave").value;
                if (isEmpty(text) || isEmpty(clave)) {
                    alert("Debe especificar nombre y clave");
                    return false;
                } else {
                    return true;
                }
            }
-->
        </script>
    </head>

    <body>
        <form action="" method="get" onsubmit="return check()">
            Nombre:<input type="text" name="nombre" id="idnombre"><br />
        Clave:<input type="password" name="clave" id="idclave" /> <br />
        <input type="submit" name="enviar" id="idenviar" value="Entrar" onkeypress="">
    </form>
    <footer>
        <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
    </footer>
</body>
</html>