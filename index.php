<?php


?>
<html>
    <meta charset="utf-8">
    <head>
        <title>PROGRESS COUNTER</title>
        <link rel="stylesheet" href="node_modules/materialize-css/dist/css/materialize.min.css"/>
        <link rel="icon" type="text/css" href="icon.png">
        <style>
            @font-face{
                src: url('pcs-normal/fonts/lcd/LCD.ttf');
                font-family:lcd;
            }
            a{
                font-family: google;
            }
            
            h1{
                font-family: lcd;
            }
            @font-face{
                src: url('pcs-normal/fonts/Montserrat-Medium.ttf');
                font-family:google;
            }
        </style>
    </head>
    <body>
        <main class="container center">
            <h1>PROGRESS COUNTER</h1>
            <div class="row">
                <div class="col s12">
                    <img src="graph.gif" class="responsive-img"/>
                </div>
            </div>
<!--            -->
            <div class="row">
                <div class="col s6">
                    <a id="btn1" href="pcs-normal/" class="btn-large blue col s12 z-depth-3" style="height:auto;"><b><span style="color:red;">[ 1 ]</span> Normal Counter</b> - for unique and same IRCS Names/Single Product</a>
                </div>
            
                <div class="col s6">
                   <a id="btn2" href="pcs-dual-product/" class="btn-large blue col s12 z-depth-3" style="height:auto;"><b><span style="color:red;">[ 2 ]</span> Multi-Product Counter</b> - for switching last process with different product output</a>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col s6">
                    <a id="btn3" href="pcs-standard/" class="btn-large blue col s12 z-depth-3" style="height:auto;"><b><span style="color:red;">[ 3 ]</span>Standard Progress Counter</b> - Most Compatible Counter</a>
                    </div>
            </div>
<!--            -->
            
        </main>
    </body>
    <script type="text/javascript">
        document.addEventListener("keypress",function(e){
             if(e.keyCode == 49 || e.keyCode == 97){
                document.getElementById('btn1').click();
            }
            if(e.keyCode == 50 || e.keyCode == 98){
                document.getElementById('btn2').click();
            }

            if(e.keyCode == 51 || e.keyCode == 99){
                document.getElementById('btn3').click();
            }
        });
    </script>
</html>