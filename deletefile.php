<?php
function delete($file){
  
    if (file_exists($file))
   unlink($file);   
  }
?>
