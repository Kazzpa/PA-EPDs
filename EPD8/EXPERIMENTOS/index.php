<html>
    <script type="text/javascript">
        //crono
        var cronoId = null;
        var cronoEjecutando = false;
        var horas = 0, minutos = 0, segundos = 0, decimas = 0;
        function detenerCrono(){
            //cancela la funcion que invoca, cadad cierto intervalo
            if(!cronoEjecutando){
                clearTimeout(cronoId);
            }
            cronoEjecutando = false;
        }
        //asigna los valores de las cajas de textos a las variables
        //horas, minutos y segundos y pone las decimas a cero.
        function inicializarValoresCrono(){
            horas = document.getElementById("idthoras").value;
            minutos = document.getElementById("idtminutos").value;
            segundos = document.getElementById("idtsegundos").value;
            decimas = 0;
        }
        function iniciarCrono(){
            inicializarValoresCrono();
            detenerCrono();
            mostrarCrono();
        }
        function actualizarCrono(){
             if(horas == 0 && minutos == 0 && segundos == 0 && decimas == 0){
                alert("Final de la cuenta atrás");
                detenerCrono();
                return true;
            }
            
            decimas--;
            if(decimas < 0){
                decimas = 9;
                segundos--;
            }
            if(segundos < 0){
                segundos = 59;
                minutos--;
            }
            if(minutos < 0){
                minutos = 59;
                horas--;
            }
        }
        function actualizarHoras(){
            var horas = document.getElementById("idthoras").value;
            if (horas == ""){
                document.getElementById("idthoras").value = 0;
            }
        }
        function actualizarMinutos(){
            var minutos = document.getElementById("idtminutos").value;
            if(minutos > 59){
                document.getElementById("idtminutos").value = minutos % 60;
                var horas = document.getElementById("idthoras").value;
                document.getElementById("idthoras").value = parseInt(horas + minutos/60);
                actualizarHoras();
            } else if (minutos == ""){
                document.getElementById("idtminutos").value = 0;
            }
        }
        function actualizarSegundos(){
            var segundos = document.getElementById("idtsegundos").value;
            if(segundos > 59){
                document.getElementById("idtsegundos").value = segundos % 60;
                var minutos = document.getElementById("idtminutos").value;
                document.getElementById("idtminutos").value = parseInt(minutos + segundos/60);
                actualizarMinutos();
            } else if (segundos == ""){
                document.getElementById("idtsegundos").value = 0;
            }
        }
        function mostrarCrono(){
            //actualizar los datos del crono
            if(actualizarCrono()){
                return true;
            }
            //formatear salida
            formatoSalidaCrono(horas, minutos, segundos, decimas);
            document.crono.tcrono.value = cronoSalida;
            //permite volver a ejecutar la funcion mostrarCrono despues 
            //de un intervalo de tiempo. Equivale a poner que se actualiza
            //cada vez que pase una decima (1s == 1000 milisegundos)
            cronoId = setTimeout("mostrarCrono()", 100);
        }
        function dosDigitos(e){
            if(e < 10){
                return "0" + e;
            } else {
                return e;
            }
        }
        function formatoSalidaCrono(h, m, s, d){
            cronoSalida = "0";
            cronoSalida = dosDigitos(h);
            cronoSalida += ":" + dosDigitos(m);
            cronoSalida += ":" + dosDigitos(s);
            cronoSalida += ":" + decimas;
        }
        function esNumero(e){
            var pnum = /^[0-9]+$/;
            
            var keynum = e.which;
            //Objeto string manipula cadena de caracteres
            //fromCharCode convierte el valor unicode asociado
            //a una cadena
            var keychar = String.fromCharCode(keynum);
            //si el caracter es un numero o las teclas de borrar
            if(pnum.test(keychar) || keynum == 8 || keynum == 0){
                return true;
            } else {
                return false;
            }
        }
    </script>
    <head>
        <meta charset="UTF-8">
        <title>EPD8-Experimento</title>
    </head>
    <body>
        <form name="crono">
            <!--Con el return en onkeypress evitamos que se dibuje la tecla que hemos pulsado si no es un numero
            y no se llama a la funcion actualizarX() porque al no ser dibujada no ha cambiado.-->
            <input name="thoras" id="idthoras" value="0" onkeypress="return esNumero(event)" onchange="actualizarHoras()"/> horas <br/> 
            <input name="tminutos" id="idtminutos" value="0" onkeypress="return esNumero(event)" onchange="actualizarMinutos()"/> minutos <br/> 
            <input name="tsegundos" id="idtsegundos" value="0" onkeypress="return esNumero(event)" onchange="actualizarSegundos()"/> segundos <br/> 

            <input type="button" name="botVal" value="iniciar" onclick="iniciarCrono()"/>
            <input type="button" name="botDet" value="detener" onclick="detenerCrono()"/> <br/><br/>

            <input type="text" name="tcrono" value="00:00:00:0" />
        </form>
    </body>
</html>
