<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="es"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Mobile Hunt - UAM Azcapotzalco</title>
	<meta name="description" content="Proyecto Terminal que consta de:
    Una aplicación para un dispositivo móvil con Sistema Operativo Android, que permita obtener su ubicación en coordenadas geográficas (Latitud y Longitud)y transmitirlas a un servidor web cada determinado tiempo.
    Un conjunto de servicios web que permita registrar y procesar las ubicaciones enviadas por la aplicación móvil.
    Esta página web, donde se podrá consultar en Tiempo Real las últimas ubicaciones del dispositivo móvil, además de poder delimitar mediante un polígono un aréa geografica, que en caso de ser sobrepasada envía mail al administrador de la aplicación.">
	<meta name="author" content="Jorge Raymundo Castillo Velázquez">

	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="css/style.css">

	<script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>
<body>

	<div id="header-container">
		<header class="wrapper clearfix">
			<h1 id="title">Proyecto Mobile Hunt<br>UAM Azcapotzalco</h1>
			<nav>
				<ul>
					<li><a href="#">nav ul li a</a></li>
					<li><a href="#">nav ul li a</a></li>
					<li><a href="#">nav ul li a</a></li>
				</ul>
			</nav>
		</header>
	</div>
	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			
			<article>
				<header>
					<h1>Institución/Compañia:</h1>
					<p>Selecciona de la siguiente lista la Institución o Compañia que identifica al dispositivo móvil que desas ubicar:
                    <br>
                    <form name="frmComp" id="frmComp" action="setusr.php" method="get">
        <?php 
            include('conectar.php');
            //institucion
            $result=mysql_query("SELECT DISTINCT nombre FROM institucion") or die("error".mysql_error());                                    
            $option="<option value=''>Elige Institución/Compañia</option>";
            $cont=0;
            while ($row=mysql_fetch_array($result)){
                $option=$option."<option value='$cont'>$row[0]</option>";
                $cont++;
            }
            echo  ("<select name='ins' id='ins'>$option</select>");
        ?>
        <input type="submit" value="aceptar" align="center" />
        </form>
                    </p>
				</header>
			</article>
			
			<aside>
				<h3>Descripción</h3>
			  <p>	Mobile Hunt es el nombre del Proyecto Terminal elaborado para la obtención del grado de Ingeniero en Computación por parte de la Universidad Autonoma Metropolitana Unidad Azcapotzalco (UAM-A).</p>
			  <p>Este proyecto  fué diseñado e implementado por el alumno <b>Jorge Raymundo Castillo Velázquez</b> con ayuda y asesoría del <b>Ing. Marío Alberto Lagos Acosta</b>.</p>
				<p>El Proyecto consta de:
				  <ul>
                  	<li><strong>Una aplicación</strong> para dispositivo moviles con Sistema Operativo Android, que permite obtener su ubicación en coordenadas geográficas décimales (Latitud y Longitud) y transmitirlas a un servidor web cada determinado tiempo.</li>
                    <li><strong>Un conjunto de servicios web</strong> que permiten registrar y procesar las ubicaciones enviadas por la aplicación móvil.</li>
                    <li><strong>Esta página web</strong>, donde se podrá consultar en Tiempo Real las últimas ubicaciones del dispositivo móvil, además de poder delimitar mediante un polígono un aréa geografica, que en caso de ser sobrepasadas, se envía un mail al administrador de la aplicación notificando el suceso y emitiendo una señal de alarma en el dispositivo móvil.</li>
              </ul>				  
				  </p>
			</aside>
			
		</div> <!-- #main -->
	</div> <!-- #main-container -->

	<div id="footer-container">
		<footer class="wrapper">
			<h3>footer</h3>
		</footer>
	</div>

</body>
</html>
