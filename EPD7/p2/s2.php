<html>
    <head>
        <title>EPD7-P2 snippet2</title>
    </head>

    <body><!-- Utilizo el snippet de borrar el texto cuando estemos en focus -->
        <nav>Nav:<br/>
            <a href="index.php">Snippet 1: Clear field on focus </a><br/>
            <a href="s3.php">Snippet 3 : Test if Mac or PC with JavaScript </a><br/>
        </nav>
        <br/>
        <a href="https://css-tricks.com/snippets/javascript/random-hex-color/">Enlace : Random Hex Color</a>
        <p id="p2">Reload the page to get a new color!</p>


        <footer>
            <p>Posted by grupo 4:<br /> Javier Bermejo Torrent, Andr&eacute;s Carrillo Bejarano, Ander Lakidain de Arriba</p>
        </footer>
        
        <script>
            document.getElementById("p2").style.color = Math.floor(Math.random() * 16777215).toString(16);
        </script>
    </body>
</html>