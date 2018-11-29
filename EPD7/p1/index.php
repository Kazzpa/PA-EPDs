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
                ini = str.indexOf("(");
                mid = str.indexOf(",");
                last = str.indexOf(")");
                if (ini < 0 || last < 0) {
                    document.write("Invalido el comando");
                    return -1;
                }
                //OP
                var op = str.substring(0, ini);

                var a = str.substring(ini + 1, mid);
                //si hay 2 atributos
                var res;
                if (mid != -1) {
                    var b = str.substring(mid + 1, last);
                    res = [op,a,b];
                }else{
                    res = [op,a];
                }
                return res;
                
            }
            function trata(str, cad) {
                ini = str.indexOf("(");
                mid = str.indexOf(",");
                last = str.indexOf(")");
                if (ini < 0 || last < 0) {
                    document.write("Invalido el comando");
                    return -1;
                }
                //OP
                var op = str.substring(0, ini);

                var a = str.substring(ini + 1, mid);
                //si hay 2 atributos
                if (mid >= 0) {
                    var b = str.substring(mid + 1, last);
                }
                switch (op) {
                    //devuelve subcadena de cad desde  i a j
                    case "sub":
                        inta = parseInt(a);
                        intb = parseInt(b);
                        //comprobamos que sean numeros
                        if (!isNaN(inta) && !isNaN(intb)) {
                            if (inta > intb || intb > cad.length || inta < 0) {
                                return -1;
                            }
                        } else {
                            return -1;
                        }
                        return cad.substring(inta, intb + 1);


                        break
                        //unico parametro
                        //concatena a al final de cad
                    case "cat":
                        if (mid >= 0) {
                            return -1;
                        }
                        //TRABAJA
                        return cad.concat(a);
                        break;
                        //remplaza en cad a por b
                    case "rep":
                        return cad.replace(a, b);
                        break;
                    default:
                        return "No valida op";
                        break;
                }
            }
            //-->
        </script>
    </head>
    <body>
        <script type="text/javascript">
//<!--
//Cadena = "cad;op(a,b        );opb(a,b)"
            var cadena = prompt("Envia la operacion:", "");
            var cadArr = cadena.split(";");
            var cad = cadArr[0];
            for (var i = 1; i < cadArr.length; i++) {
                operandos = valida(cadArr[i]);
                var res = trata(cadArr[i], cad);
                if (res == -1) {
                    alert("error");
                } else {
                    res.concat("<br>");
                    document.write(res);
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
