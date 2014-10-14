<?php
    function mk($idUsr,$nomUsr,$nomInsti,$fechaQuery){
        include('conectar.php');
        $query ="SELECT idpuntos,longitud,latitud,fecha,provider FROM puntos WHERE usuarios_idUsuarios='".$idUsr."' AND DATE_FORMAT(fecha,'%d-%m-%Y')='".$fechaQuery."'";
        $result = mysql_query($query) or die("error".mysql_error());
        if (!$result)
            die('Invalid query: ' . mysql_error());
        // PHP5
        // Creates the Document.
        $dom = new DOMDocument('1.0', 'UTF-8');
        // Creates the root KML element and appends it to the root document.
        $node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
        $parNode = $dom->appendChild($node);
        // Creates a KML Document element and append it to the KML element.
        $dnode = $dom->createElement('Document');
        $docNode = $parNode->appendChild($dnode);
        // Creates the two Style elements, one for restaurant and one for bar, and append the elements to the Document element.
        $restStyleNode = $dom->createElement('Style');
        $restStyleNode->setAttribute('id', 'restaurantStyle');
        $restIconstyleNode = $dom->createElement('IconStyle');
        $restIconstyleNode->setAttribute('id', 'restaurantIcon');
        $restIconNode = $dom->createElement('Icon');
        //icono adecuado 
        $restHref = $dom->createElement('href', '://maps.google.com/mapfiles/kml/pal2/icon5.png');
        $restIconNode->appendChild($restHref);
        $restIconstyleNode->appendChild($restIconNode);
          
        $restStyleNode->appendChild($restIconstyleNode);
        $docNode->appendChild($restStyleNode);
        $barStyleNode = $dom->createElement('Style');
        $barStyleNode->setAttribute('id', 'barStyle');
        $barIconstyleNode = $dom->createElement('IconStyle');
        $barIconstyleNode->setAttribute('id', 'barIcon');
        $barIconNode = $dom->createElement('Icon');
        $barHref = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon27.png');
        $barIconNode->appendChild($barHref);
        $barIconstyleNode->appendChild($barIconNode);
        $barStyleNode->appendChild($barIconstyleNode);
        $docNode->appendChild($barStyleNode);
        // Iterates through the MySQL results, creating one Placemark for each row.
        while ($row = mysql_fetch_array($result)){
            // Creates a Placemark and append it to the Document.
            $node = $dom->createElement('Placemark');
            $placeNode = $docNode->appendChild($node);
            // Creates an id attribute and assign it the value of id column.
            $placeNode->setAttribute('id', $row[0]);
            // Create name, and description elements and assigns them the values of the name and address columns from the results.
            $nameNode = $dom->createElement('name',htmlentities("Institucion/Compania: $nomInsti"));
            $placeNode->appendChild($nameNode);
            $descNode = $dom->createElement('description', "Usuario: $nomUsr\nLat: ".$row[2]."\nLong: ".$row[1]."\n".$row[3]."\n".$row[4]);
            $placeNode->appendChild($descNode);
            $styleUrl = $dom->createElement('styleUrl', '#restaurantStyle');
            $placeNode->appendChild($styleUrl);
            // Creates a Point element.
            $pointNode = $dom->createElement('Point');
            $placeNode->appendChild($pointNode);
            // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
            //Latitud (y)  , longitud (x)
            $coorStr = $row[2] . ',' . $row[1];
            $coorNode = $dom->createElement('coordinates', $coorStr);
            $pointNode->appendChild($coorNode);
        }
        $ruta = $dom->saveXML();
        //$kmlSave = $dom->save("/home/aiturbe/public_html/raymundo/files/ruta.kml");
        //obtenemos timestamp para crear numero aleatorio de 
        $t=time();
        $rutaKml="files/".$t.".kml";
        $kmlSave = $dom->save($rutaKml);
        //header('Content-type: application/vnd.google-earth.kml+xml');
        //header('Content-disposition: attachment; filename="myfilename.kml"');  
        //Para dar opcion de descargar KML desde explorador, quitar kmlSave

        //echo $ruta;
        echo $kmlSave;
        return $rutaKml;



        /*
        //ECHO
                // Creates an array of strings to hold the lines of the KML file.
                $kml = array('<?xml version="1.0" encoding="UTF-8"?>');
                $kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
                $kml[] = ' <Document>';
                $kml[] = ' <Style id="restaurantStyle">';
                $kml[] = ' <IconStyle id="restuarantIcon">';
                $kml[] = ' <Icon>';
                $kml[] = ' <href>http://maps.google.com/mapfiles/kml/pal2/icon63.png</href>';
                $kml[] = ' </Icon>';
                $kml[] = ' </IconStyle>';
                $kml[] = ' </Style>';
                $kml[] = ' <Style id="barStyle">';
                $kml[] = ' <IconStyle id="barIcon">';
                $kml[] = ' <Icon>';
                $kml[] = ' <href>http://maps.google.com/mapfiles/kml/pal2/icon27.png</href>';
                $kml[] = ' </Icon>';
                $kml[] = ' </IconStyle>';
                $kml[] = ' </Style>';
                
                while ($row=mysql_fetch_array($result)){
                    $kml[] = ' <Placemark id="' . $row[0] . '">';
                    $kml[] = ' <name>' . htmlentities('UAM') . '</name>';
                    $kml[] = ' <description>' . htmlentities('raymundo') . '</description>';
                    $kml[] = ' <styleUrl>#restaurantStyle</styleUrl>';
                    $kml[] = ' <Point>';
                    $kml[] = ' <coordinates>' . $row[1] . ','  . $row[2] . '</coordinates>';
                    $kml[] = ' </Point>';
                    $kml[] = ' </Placemark>';
                    
                }
                // End XML file
                
                
                $kml[] = ' </Document>';
                $kml[] = '</kml>';
                $kmlOutput = join("\n", $kml);
                header('Content-type: application/vnd.google-earth.kml+xml');
                header('Content-disposition: attachment; filename="myfilename.kml"'); 
                echo $kmlOutput;
         */       
    }            
            
?>