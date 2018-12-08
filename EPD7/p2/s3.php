<html>
    <head>
        <title>EPD7-P2 snippet2</title>
    </head>

    <body><!-- Utilizo el snippet de borrar el texto cuando estemos en focus -->
        <nav>Nav:<br/>
            <a href="index.php">Snippet 1: Clear field on focus </a><br/>
            <a href="s2.php">Snippet 2 : Random Hex Color </a><br/>

        </nav>
        <br/>
        <a href="https://css-tricks.com/snippets/javascript/test-mac-pc-javascript/">Enlace : Test if Mac or PC with JavaScript</a>
        El snippet lo he modificado para que no utilice jquery
        

        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
        <script>
            if (navigator.userAgent.indexOf('Mac OS X') != -1) {
                alert("mac");
            } else {
                alert("pc");
            }
        </script>
    </body>
</html>