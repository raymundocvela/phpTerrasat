
<script type="text/javascript"
function isInPolygon(){
    var coordinate = new google.maps.LatLng(<?echo $_REQUEST['lonx']?>,<?echo $_REQUEST['laty']?>);                                                                                                                                                                                                       
    var polygon = new google.maps.Polygon([], "#000000", 1, 1, "#336699", 0.3);
    var isWithinPolygon = polygon.containsLatLng(coordinate);
}

></script>


    <?php
    include('conectar.php');
    
   //obtener id usr
$qUsr="SELECT idusuarios FROM usuarios WHERE usuario='".$_REQUEST['usr']."'";
$result=mysql_query($qUsr);
$idUsr=mysql_fetch_array($result);

    //$phpdate=date("Y-m-d H:i:s",strtotime($_REQUEST['timestamp']));
    //$phpdate=date("Y-m-d H:i:s",($_REQUEST['timestamp']));
    $phpdate=date("Y-m-d H:i:s");
    //$query="INSERT INTO puntos (usuarios_idUsuarios, longitud, latitud, fecha, provider) VALUES ('".$idUsr[0]."','".$_REQUEST['lonx']."','".$_REQUEST['laty']."','".$_REQUEST['timeStamp']."','".$_REQUEST['bestprov']."')";
    $query="INSERT INTO puntos (usuarios_idUsuarios, longitud, latitud, fecha, provider) VALUES ('".$idUsr[0]."','".$_REQUEST['lonx']."','".$_REQUEST['laty']."','".$phpdate."','".$_REQUEST['bestprov']."')";
    $insert=mysql_query($query);
     if(!$insert){
         $responsePhp="_0";
     }
     else $responsePhp="_1";
     
     //print(json_encode($responsePhp."consulta: ".$query));
     print(json_encode($responsePhp."phpdate: ".$phpdate."consulta: ".$query));
     mysql_close();
    ?>
