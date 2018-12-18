<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>EPD8-P6</title>
        <script src="jquery-3.3.1.min.js"></script>
        <script type="text/javascript" >
            //<!--
            //WIP
            function validaTodo(){
                //recoger valores
                var edad = document.getElementById("edad").value;
                var peso = document.getElementById("peso").value;
                if(esNumero(edad,"errorEdad") &&
                        validaPeso("errorPeso",peso))
            }
            //dejara cambiar el campo si es un valor numerico
            function esNumero(valor, idError) {
                var pnum = /^[0-9]+$/;

                //si el caracter es un numero
                if (pnum.test(valor)) {
                    document.getElementById(idError).innerHTML = "";
                    return true;
                } else {
                    document.getElementById(idError).innerHTML = "No es numerico";
                    return false;
                }
            }
            //Comprueba que el campo sea correcto
            function validaWeb(idError, valor) {
                reg = /^(www)\.(\w)*\.(\w){1,3}$/;
                if ( reg.test(valor) || valor.length == 0 ) {
                    document.getElementById(idError).innerHTML = "";
                    return true;
                } else {
                    document.getElementById(idError).innerHTML = "Url no valida, debe ser formato www.paginaquesea.com";
                    return false;
                }
            }
            //Dejara cambiar el valor si es un campo con el formato de 6 numeros
            // y decimal con coma ,
            function validaPeso(idError, valor) {
                reg = /^(\d*){1,6}\,?(\d*){1,4}$/;
                console.log(valor + reg.test(valor));
                if (reg.test(valor) && valor.length < 7) {
                    document.getElementById(idError).innerHTML = "";
                    return true;
                } else {
                    document.getElementById(idError).innerHTML = "Peso no valido, maximo 6 numeros";
                    return false;
                }
            }
            //Esta funcion sirve para mostrar o ocultar distintos campos del
            //en funcion de el valor de cmpValor que le pasemos
            //ocultara idElem si no se cumple y mostrara idElem2 en el caso de
            //que se le haya mandado alguno
            function mostrar(idValor, idElem, idElem2, cmpValor) {
                var x = document.getElementById(idElem);
                var valor = document.getElementById(idValor);
                if (idElem2 != null) {
                    var x2 = document.getElementById(idElem2);
                }
                if (valor.value == cmpValor) {
                    x.style.display = "block";
                    if (x2 != null) {
                        x2.style.display = "none";
                    }
                    switch (idElem) {
                        case "fumador":
                            document.getElementById("cigarros").disabled = false;
                            break;
                        case "deporte":
                            document.getElementById("deportesdias").disabled = false;
                            document.getElementById("sportsdone").disabled = false;
                            break;
                    }
                } else if (valor.value != cmpValor) {
                    x.style.display = "none";
                    if (x2 != null) {
                        x2.style.display = "block";
                    }
                    switch (idElem) {
                        case "fumador":
                            document.getElementById("cigarros").disabled = true;
                            break;
                        case "deporte":
                            document.getElementById("deportesdias").disabled = true;
                            document.getElementById("sportsdone").disabled = true;
                            break;
                    }
                }
            }
                    --></script>
    </head>
    <body>
        <form action="" method="POST">
            <div id ="error" class="error"> </div><br/>
            Edad :<input type="number" id="edad" name="edad" 
            onkeypress="return esNumero(this.value, 'errorEdad')" required>
            <div id="errorEdad"></div><br/>
            Sexo:<br/>
            <input type="radio" name="gender" value="male" checked> hombre<br/>
            <input type="radio" name="gender" value="female"> mujer<br/>
            <input type="radio" name="gender" value="other"> otro<br/>
            Peso :<input type="text" id = "peso" name="peso" onblur="validaPeso('errorPeso', this.value)" required><br/><div id="errorPeso"></div>
            ¿Es Fumador?:<select id="smoker" name="isSmoker" onblur="return mostrar('smoker', 'fumador', null, 'yes')" >
                <option value="no">No </option>
                <option value="yes">Si </option>
            </select><br/>
            <div id= "fumador" >
                Cuantos cigarros fuma a la semana :<input type="text" id="cigarros"
                                                          name="cigarros" onkeypress="return esNumero( 'errorCigarro')"
                                                          required><br/><div id="errorCigarro"> </div></div>
            ¿Realiza deporte?:<select name="doesSports" id="deporteinput"
                                      onchange="return mostrar('deporteinput', 'deporte', null, 'yes')" >
                <option value="no">No </option>
                <option value="yes">Si </option>
            </select><br/>
            <div id="deporte">
                ¿Cuantos días a la semana realiza deporte?<input type="text" id="deportesdias"
                                                                 name="sportsDay" onkeypress="return esNumero(this.value, 'errordias')"
                                                                 required><br/><div id="errordias"></div>
                ¿Que deporte realiza?<input type="text" id="sportsdone" name="sportdone" required><br/>
                ¿Sigue alguna web de hábitos de saludables?<input type="text" 
                                                                  name="websports"   id="websports" onblur="validaWeb('errorWeb', this.value)"><br/>
                <div id="errorWeb"></div>
            </div>
            ¿Vas en coche a la universidad/trabajo?:<select id="car" name="usesCar"
                                                            onblur="return mostrar( 'car', 'coche', 'nocoche', 'yes')" >
                <option value="yes">Si </option>
                <option value="no">No </option>
            </select><br/>
            <div id="coche">
                ¿Por qué no utiliza el transporte público? <input type="text" name="notPublic" d><br/>
            </div>
            <div id="nocoche">
                ¿En que medio viene? <select name="usesCar"  id="type" 
                                             onblur="return mostrar( 'type', 'cual', null, 'other')">
                    <option value="public">Transporte publico </option>
                    <option value="walk">Andando </option>
                    <option value="bicycle">Bicicleta </option>
                    <option value="other">Otro </option>
                </select><br/>

                <div id="cual">
                    ¿Cual?<input  type="text" name="typeTransport">
                </div></div>
            <input type="submit" name="enviar" value="Enviar" onsubmit="return validaTodo()">
        </form>
        <script type="text/javascript">
<!--
            //iniciacion teniendo en cuenta los valores por defecto del html
            document.getElementById("fumador").style.display = "none";
            document.getElementById("deporte").style.display = "none";
            document.getElementById("nocoche").style.display = "none";
            document.getElementById("cual").style.display = "none";
            document.getElementById("cigarros").disabled = true;
            document.getElementById("deportesdias").disabled = true;
            document.getElementById("sportsdone").disabled = true;
            //-->
        </script>
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>
