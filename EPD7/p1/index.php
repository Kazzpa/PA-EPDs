<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>EPD7-P1</title>
        <script type="text/javascript">
//<!--
            function valida(str) {
                var ini = str.indexOf("(");
                var mid = str.indexOf(",");
                var last = str.indexOf(")");
                if (ini < 0 || last < 0) {
                    document.write("Invalido el comando");
                    return -1;
                }
                //OP
                var op = str.substring(0, ini);

                //si hay 2 atributos
                var res;
                if (mid != -1) {
                    var a = str.substring(ini + 1, mid);
                    var b = str.substring(mid + 1, last);
                    res = [op, a, b];
                } else {

                    var a = str.substring(ini + 1, last);
                    res = [op, a];
                }
                //si hay 1 
                return res;

            }
            function trata(str, cad) {
                var op = str[0];
                var a = str[1];
                //comprueba si hay 2 atributos
                if (str.length > 2) {
                    var b = str[2];
                }
                switch (op) {
                    case "sub":
                        return sub(cad,a,b);
                        break
                    case "cat":
                        return cat(cad,a);
                        break;
                    case "rep":
                        return rep(cad,a,b);
                        break;
                    default:
                        return "No valida op";
                        break;
                }
            }
            function sub(cad, a, b) {
                var inta = parseInt(a);
                var intb = parseInt(b);
                //comprobamos que sean numeros
                if (!isNaN(inta) && !isNaN(intb)) {
                    if (inta > intb || intb > cad.length || inta < 0) {
                        return -1;
                    }
                } else {
                    return -1;
                }
                return cad.substring(inta - 1, intb + 1);
            }
            function cat(cad, a) {
                return cad.concat(a);
            }
            function rep(cad, a, b) {
                var regex = new RegExp(a, "g");
                return cad.replace(regex, b);
            }
            //-->
        </script>
    </head>
    <body>
        <script type="text/javascript">
//<!--
            //Cadena = "cad;op(a,b);opb(a,b)"
            cadena = prompt("Envia la operacion:", "");
            cadArr = cadena.split(";");
            cad = cadArr[0];
            end = "";
            //realizamos cada operacion
            for (var i = 1; i < cadArr.length; i++) {
                //cadArr[i] = ['op(a,b)`] o [op(a)]
                operandos = valida(cadArr[i]);
                res = trata(operandos, cad);
                cad = res;
                if (res == -1) {
                    alert("error");
                } else {
                    document.write(" " + res);
                }
            }
            if (cadArr.length < 2) {
                alert("introduzca mas campos");
            }

//-->
        </script>
        <?php
        // put your code here
        ?><footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>
