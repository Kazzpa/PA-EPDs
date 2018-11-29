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
            function trata(str, cad) {
                i = str.indexOf("(");
                j = str.indexOf(",");
                k = str.indexOf(")");
                if (i < 0 || k < 0) {
                    document.write("Invalido el comando");
                    return -1;
                }
                //OP
                var op = str.substring(0, i);

                var a = str.substring(i + 1, j);
                //si hay 2 atributos
                if (j >= 0) {
                    var b = str.substring(j + 1, k);
                }
                switch (op) {
                    //devuelve subcadena de cad desde  i a j
                    case sub:
                        inta = parseInt(a);
                        intb = parseInt(b);
                        //comprobamos que sean numeros
                        if (!isNaN(inta) && !isNaN(intb)) {
                            if (inta > intb || intb > cad.length || inta < 0) {
                                return -1;
                            }
                        }else{
                            return -1;
                        }
                        return cad.substring(inta,intb);
                        

                        break
                        //unico parametro
                        //concatena a al final de cad
                    case cat:
                        if (j >= 0) {
                            return -1;
                        }
                        //TRABAJA
                        return cad.concat(a);
                        break;
                        //remplaza en cad a por b
                    case rep:
                        return cad.replace(a,b);
                        break;
                    default:
                        document.write("No valida op");
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
                trata(cadArr[i], cad);
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
