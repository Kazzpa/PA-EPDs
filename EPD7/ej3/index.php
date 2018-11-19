<html>
    <head>
        <title>EPD7-EJ3</title>
        <script type="text/javascript">
            function imprimedivi() {
                var i = 0;
                var size = 10;
                while (i < size / 2) {
                    var j = 1;
                    while(j < size){
                        if(j%i == 0){
                            document.write(j);
                        }
                        j++;
                    }
                    document.write("<br>");
                    i++;
                }
            }
            imprimedivi();
        </script>
    </head>

    <body>
    </body>
</html>