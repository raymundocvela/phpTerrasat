<?php
    if (!isset($_SESSION)) {
    session_start();
    }
    else echo "sesión iniciada";

    $js="";
    include('conectar.php');
    $js=$_REQUEST['coords1'];
    if($js!=""){
        $query="UPDATE usuarios SET restriccion='".$js."' WHERE idusuarios ='".$_SESSION['idUsr']."'";
        $result=mysql_query($query) or die ("error".mysql_error());
        if($result!=1)
            echo "Restricción agregada correctamente";
        else echo "Error al agregar restricción ".$result;
    }
    else echo"<br>El Java Script no contiene información";
    mysql_close();
?>
