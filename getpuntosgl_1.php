<?php
    if (!isset($_SESSION)) {
    session_start();
    }
    else echo "sesión iniciada";
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html style="height:100%" xmlns="http://www.w3.org/1999/xhtml"> <!--style="height:100%" es para poder ocupar el porcentaje en el div del mapa, si no se pone el div q se genera es de altura � height 0-->



<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <title> Hunt GPS - Proyecto Terminal Ingeniería en Computación UAM Azcapotzalco</title>

    <!-- API Google MAPS muestra configuración Mapa-->
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script> 
    
    <!-- Hoja de Estilo-->
    <link href="Style/HuntGPS.css" rel="stylesheet" type="text/css" />

    <!--Favicon-->
    <link REL="SHORTCUT ICON" HREF="image/Favicon.ico">

    <!--Reloj-->
        <script type="text/javascript"><!--
         var rutaKml=0;
        //se ponen <!-- por si el explorador no es compatibel con Javascript no salga impreso el codigo            
            function HoraActual(hora, minuto, segundo){
                segundo = segundo + 1;
                if(segundo == 60) {
                    minuto = minuto + 1;
                    segundo = 0;
                    if(minuto == 60) {
                        minuto = 0;
                        hora = hora + 1;
                        if(hora == 24) {
                            hora = 0;
                        }
                    }
                }

                if(hora < 10) hora = '0' + hora;
                if(minuto < 10) minuto = '0' + minuto;
                if(segundo < 10) segundo = '0' + segundo;
                HoraCompleta= hora + " : " + minuto + " : " + segundo;
                document.getElementById('relojMenu').innerHTML = HoraCompleta;
                setTimeout("HoraActual("+hora+", "+minuto+", "+segundo+")", 1000);
            } 

//    <!-- API Google MAPS muestra configuración Mapa-->
            
 //     <!-- Primer Mapa usado-->
            function initialize() {
                var latlng = new google.maps.LatLng(23.919722222222223, -102.1625); //Centro del Mapa
                var settings = {
                    zoom: 6,
                    center: latlng,
                    mapTypeControl: true,
                    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
                    navigationControl: true,
                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map_canvas"), settings);
            }
           
           
           function loadkml(){
                var latlng = new google.maps.LatLng(23.919722222222223, -102.1625); //Centro del Mapa
                var settings = {
                    zoom: 6,
                    center: latlng,
                    mapTypeControl: true,
                    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
                    navigationControl: true,
                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map_canvas"), settings)
                var rutaLayer = new google.maps.KmlLayer('http://igconsultores.net/raymundo/'+rutaKml);
                rutaLayer.setMap(map);
                //window.open("https://maps.google.com/maps?q=http:%2F%2Figconsultores.net%2Fraymundo%2Ffiles%2F"+"1340900465.kml");
           }
          
 
            function abrirPag(url){
                window.location.href = url; //abre la pagina en la misma ventana
                //window.open(url,"","algun parametro que desees"); abre la pagina en nueva ventana
            }

            function funciones(){//Juntamos las funciones en una sola, para poderlas ejecutar en el onload del body

                initialize();
                HoraActual(<?php echo date("H",time()/*-3600*/).", ".date("i").", ".date("s"); ?>); //time()-3600 resta 1 hora al tiempo del servidor para ajustarlo a nuestra hora
            }
          </script>
      

</head>     



<body onload="funciones()">
<!-- dothird(); para cargar otra accion en el body -->


	<div class="contenedor">
    	<div class="encabezado">
            <h1>Mobile Hunt - Proyecto Terminal
             <br />Ingeniería en Computación UAM Azcapotzalco</h1>
        </div>        
        <div class="menu">
			<div class="encabezadoMenu"><h1>Panel de Administración</h1>
            	<div class="fechaMenu"><?php $fecha=date("d/m/y"/*." "."h:i:s"*/); echo $fecha;?> </div><!--fecha-->
                <div class="relojMenu" id="relojMenu"></div>
            </div>

            <div class="formulario" id="formulario" style="overflow:auto">
            	div form
                <div class="usr" id="usr" style="overflow:auto">
                    div usr
                </div>
                <!-- verificamos si existe restricción guardada
                -->
                
                
                
                
                <?php
                    include('conectar.php');
                    $query="SELECT restriccion FROM usuarios WHERE idusuarios ='".$_SESSION['idUsr']."'";
                    echo $query;
                    $result=mysql_query(query);
                    $row=mysql_fetch_array($result);
                    //$js=$row[0];
                    echo $row;
                    if($js!="")
                    {
                        echo '<script type="text/javascript">
                        function verRestriccion(){'.$js.'
                        void(prompt("",gApplication.getMap().getCenter()));
                        }
                        /* <![CDATA[ */
                        /* ]]> */
                        </script>';
                        echo '<button type="button" align="center"  onclick="verRestriccion()">Ver Restricción</button> ';                        
                    }
                 ?>
                
                <button type="button" align="center"  onclick="abrirPag('v3tool_restricciones.html')">Establecer Restricción</button> 
                <button type="button" align="center" onclick="loadkml()">Ver ruta </button>
                <?php obtenerDatos();?>
                

            </div>     
        </div>
        <div class="mapa" id="map_canvas">Mapa</div>
        <div class="pie">Pie</div>
	</div>

    

	<?php
    function obtenerDatos(){
        include('conectar.php');
        include('makerutakml_1.php');
                    
        //adecuar ID usr
        $idUsr=$_REQUEST['usr'];
        $nomInsti=$_REQUEST['nomInsti'];
        $_SESSION['idUsr']=$idUsr;
        
        //recuperar fecha
        $fechaExplode=explode('-',$_REQUEST['fecha']);
        //$fechaQuery=date('Y-m-d',mktime(0,0,0,$fechaExplode[1],$fechaExplode[0],$fechaExplode[2]));
        $fechaQuery=date('d-m-Y',mktime(0,0,0,$fechaExplode[1],$fechaExplode[0],$fechaExplode[2]));
        //echo $fechaQuery."<br>";
        
        //print_r $fechaQuery;
        
      
        //obtener nombre Usr segun id
        $result=mysql_query("SELECT usuario FROM usuarios WHERE idusuarios='".$idUsr."'") or die("error".mysql_error());
        $row=mysql_fetch_array($result);
        $nomUsr=$row[0];
        $_SESSION['nomUsr']=$nomUsr;
        
        //puntos segun idUsr
        /*consulta original
        $result=mysql_query("SELECT idpuntos,longitud,latitud,fecha,provider FROM puntos WHERE usuarios_idUsuarios='".$idUsr."' AND fecha='".$fechaQuery."'") or die("error".mysql_error());
        */
        $result=mysql_query("SELECT idpuntos,longitud,latitud,fecha,provider FROM puntos WHERE usuarios_idUsuarios='".$idUsr."' AND DATE_FORMAT(fecha,'%d-%m-%Y')='".$fechaQuery."'") or die("error".mysql_error());
        //echo "consulta SELECT idpuntos,longitud,latitud,fecha,provider FROM puntos WHERE usuarios_idUsuarios='".$idUsr."' AND DATE_FORMAT(fecha,'%d-%m-%Y')='".$fechaQuery."')";
        echo"Institucion/Compania:".$nomInsti."<br>";
        echo"Nombre de Usuario: $nomUsr <br>";
        echo"Fecha:".$fechaQuery."<br>";
        //creamos tabla
        echo "<table border = '1'> ";
        //nombre filas
        echo "<tr> ";
        echo "<td><b>ID</b></td> ";
        echo "<td><b>Longitud (x)</b></td> ";
        echo "<td><b>Latitud (y)</b></td> ";
        echo "<td><b>Fecha y hora</b></td> ";
        echo "<td><b>Provedor de localización</b></td> ";
        echo "</tr> ";
      
        //datos      
        while ($row=mysql_fetch_array($result)){
            echo "<tr> ";
            echo "<td>$row[0]</td> ";
            echo "<td>$row[1]</td> ";
            echo "<td>$row[2]</td> ";
            echo "<td>$row[3]</td> ";
            echo "<td>$row[4]</td> ";
            echo "</tr> ";
        }
        echo "</table> ";
        //echo "fintabla";
        $rutaKml=mk($idUsr,$nomUsr,$nomInsti,$fechaQuery);
        echo"kml creado: ".$rutaKml;
        
        //pasamos valor a variable de javascript para mostrar kml
        echo '<script type="text/javascript">rutaKml="'.$rutaKml.'"</script>';
    }
            
?>            

    
</body>
</html>