<?php
include('conectar.php');
//Existe usuario?
$qExistUsr="SELECT usuario FROM usuarios WHERE usuario='".$_REQUEST['usr']."'";
$result=mysql_query($qExistUsr);
$noRows=mysql_num_rows($result);
if($noRows>0) $responsePhp="Ya existe usuario"; //si existe
else {//No existe
        //Existe institucion?
        $qExistInsti="SELECT nombre FROM institucion WHERE nombre='".$_REQUEST['comp']."'";
        $result=mysql_query($qExistInsti);
        $noRows=mysql_num_rows($result);
        if($noRows>0){
            //si existe, obtener idInsti
            $qidInsti="SELECT idinstitucion FROM institucion WHERE nombre='".$_REQUEST['comp']."'";
            $result=mysql_query($qidInsti);
            $idInsti=mysql_fetch_array($result);
            $idInsti=$idInsti[0];                        
            $responsePhp="- Ya existe institucion id=".$idInsti[0]; 
        }
        else {
            //no existe,inserta institucion y obtiene idInsti
            $qInsti="INSERT INTO institucion (nombre) VALUES ('".$_REQUEST['comp']."')";
            $insInsti=mysql_query($qInsti);
            $idInsti=mysql_insert_id();
            if(!$insInsti){
                 $responsePhp="0 error insertar insti";
            }
            else $responsePhp="1 insti insertada";
        $responsePhp=$responsePhp." consulta insti".$qInsti;                        
        }
   
        //inserta usuario    
        $query="INSERT INTO usuarios (institucion_idinstitucion, usuario, descripcion, muestreo,psw_usr) VALUES ('".$idInsti."','".$_REQUEST['usr']."','".$_REQUEST['desc']."','".$_REQUEST['mues']."','".$_REQUEST['psw']."')";
        $insert=mysql_query($query);
        if(!$insert){
         $responsePhp=$responsePhp."_0 usr no insertado";
        }
        else $responsePhp=$responsePhp."_1 usr insertado";
 }
 
 print(json_encode($responsePhp." consulta usr: ".$query));
 mysql_close();
?>
