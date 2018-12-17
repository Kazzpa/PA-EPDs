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

    </head>
    <body>
        <form action="" method="POST">
            <div id ="error" class="error"> </div><br/>
            Edad :<input type="number" name="edad" onkeypress="return esNumero(event, 'errorEdad')"><div id="errorEdad"></div><br/>
            Sexo:<br/>
            <input type="radio" name="gender" value="male" checked> hombre<br/>
            <input type="radio" name="gender" value="female"> mujer<br/>
            <input type="radio" name="gender" value="other"> otro<br/>
            Peso :<input type="text" name="peso" onchange="return validaPeso(event, 'errorPeso', this.value)" required><br/><div id="errorPeso"></div>
            ¿Es Fumador?:<select id="smoker" name="isSmoker" onchange="return mostrar(event, 'smoker', 'fumador', null,'yes')" >
                <option value="no">No </option>
                <option value="yes">Si </option>
            </select><br/>
            <div id= "fumador" >
                Cuantos cigarros fuma a la semana :<input type="text" name="cigarros" onkeypress="return esNumero(event,'errorCigarro')" required><br/><div id="errorCigarro"> </div></div>
            ¿Realiza deporte?:<select name="doesSports" id="deporteinput" onchange="return mostrar(event,'deporteinput','deporte',null,'yes')" >
                <option value="yes">Si </option>
                <option value="no">No </option>
            </select><br/>
            <div id="deporte">
                ¿Cuantos días a la semana realiza deporte?<input type="text" name="sportsDay" onkeypress="return esNumero(event, 'errordias')" required><br/><div id="errordias"></div>
                ¿Que deporte realiza?<input type="text" name="sportdone" required><br/>
                ¿Sigue alguna web de hábitos de saludables?<input type="text" name="websports"><br/>
            </div>
            ¿Vas en coche a la universidad/trabajo?:<select id="car" name="usesCar" onchange="return mostrar(event, 'car', 'coche', 'nocoche','yes')" >
                <option value="yes">Si </option>
                <option value="no">No </option>
            </select><br/>
            <div id="coche">
                ¿Por qué no utiliza el transporte público? <input type="text" name="notPublic" d><br/>
            </div>
            <div id="nocoche">
                ¿En que medio viene? <select name="usesCar"  id="type" onchange="return mostrar(event,'type','cual',null,'other')">
                    <option value="public">Transporte publico </option>
                    <option value="walk">Andando </option>
                    <option value="bicycle">Bicicleta </option>
                    <option value="other">Otro </option>
                </select><br/>

                <div id="cual">
                ¿Cual?<input  type="text" name="typeTransport">
                </div></div>
            <input type="submit" name="enviar">
        </form>
        <script type="text/javascript">
//<!--
            document.onkeypress = function (myEvent) { // doesn't have to be "e"
                //console.log(myEvent.which);
            };
            //iniciacion teniendo en cuenta los valores por defecto del html
            document.getElementById("fumador").style.display = "none";
            document.getElementById("deporte").style.display = "none";
            document.getElementById("nocoche").style.display = "none";
            document.getElementById("cual").style.display = "none";
            //dejara cambiar el campo si es un valor numerico
            function esNumero(e, idError) {
                var pnum = /^[0-9]+$/;

                var keynum = e.which;
                //Objeto string manipula cadena de caracteres
                //fromCharCode convierte el valor unicode asociado
                //a una cadena
                var keychar = String.fromCharCode(keynum);
                //si el caracter es un numero o las teclas de borrar
                if (pnum.test(keychar) || keynum == 8 || keynum == 0) {
                    document.getElementById(idError).innerHTML = "";
                    return true;
                } else {
                    document.getElementById(idError).innerHTML = "No es numerico";
                    return false;
                }
            }
            //Dejara cambiar el valor si es un campo con el formato de 6 numeros
            // y decimal con coma ,
            function validaPeso(e, idError, valor) {
                //var pnum = /^([0-9],[0-9]{1,5})|([0-9]{2},[0-9]{1,4})|([0-9]{3},[0-9]{1,3})|([0-9]{4},[0-9]{1,2})|([0-9]{5},[0-9])|([0-9]{1,6})$/;
                pnum = /([0-9],[0-9]{1,5})|([0-9]{2},[0-9]{1,4})|([0-9]{3},[0-9]{1,3})|([0-9]{4},[0-9]{1,2})|([0-9]{5},[0-9])|([0-9]{1,6})/;
                pnum = /^[0-9]+([,][0-9]+)?$/;
                console.log(valor + pnum.test(valor));
                if (pnum.test(valor) && valor.length < 7) {
                    document.getElementById(idError).innerHTML = "";
                } else {
                    document.getElementById(idError).innerHTML = "Peso no valido, maximo 6 numeros";
                }
            }
            //Esta funcion sirve para mostrar o ocultar distintos campos del
            //en funcion de el valor de cmpValor que le pasemos
            //ocultara idElem si no se cumple y mostrara idElem2 en el caso de
            //que se le haya mandado alguno
            function mostrar(e, idValor, idElem, idElem2,cmpValor) {
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
                } else if (valor.value != cmpValor) {
                    x.style.display = "none";
                     if (x2 != null) {
                        x2.style.display = "block";
                    }
                }
            }
            var pnum = /^([0-9],[0-9]{1,5})|([0-9]{2},[0-9]{1,4})|([0-9]{3},[0-9]{1,3})|([0-9]{4},[0-9]{1,2})|([0-9]{5},[0-9])|([0-9]{1,6})$/;

            if ("123,12".match(pnum)) {
                document.write("123,12 matches");
            }
            if ("1212".match(pnum)) {
                document.write("1212 matches");
            }
            if ("1,12".match(pnum)) {
                document.write("1,12 matches");
            }
            //-->
        </script>
        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
    </body>
</html>
