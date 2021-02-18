<?php  
function redimensionar($archivo, $ancho_forzado){
   if (file_exists($archivo)) {
      list($width, $height, $type, $attr)= getimagesize($archivo);
      if ($ancho_forzado > $width) {
         $max_width = $width;
      } else {
         $max_width = $ancho_forzado;
      }
      $proporcion = $width / $max_width;
      if ($proporcion == 0) {
         return -1;
      }
      $height_dyn = $height / $proporcion;
   } else {
      return -1;
   }
   return array($max_width, $height_dyn);
}
?>