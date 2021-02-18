
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US" >

<head>

    <title>Subir imagen redimensionada</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link href="css/estilo.css" rel="stylesheet" type="text/css">

</head>

<body>

  <div id="contenedor">

    <form action="index.php" method="POST" enctype="multipart/form-data"/>

        Añadir imagen: <input name="archivo" id="archivo" type="file"/>
        <input class="boton_personalizado" type="submit" name="subir" value="Subir imagen"/>

    </form>
    
<?php

  include 'funcion.php';

    //Si se quiere subir una imagen
    if (isset($_POST['subir'])) {

    //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['archivo']['name'];

    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {

      //Obtenemos algunos datos necesarios sobre el archivo
      $tipo = $_FILES['archivo']['type'];
      $tamano = $_FILES['archivo']['size'];
      $temp = $_FILES['archivo']['tmp_name'];
      list($height,$width) = getimagesize('image/'.$archivo);
    
      //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
     if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000) && ($height < 796) && ($width < 1123))) {
        echo '<div><br><b>El tamaño del archivo no es correcto.<br/>
        El alto permitido es: 796px.<br/>
        El ancho permitdio es: 1123px.</b></br></div>';

        echo '<div><br><b>El alto de su documento es: ' .$height 
        .'<br/>El ancho de su documento es: ' .$width 
        .'<br/>Por tanto su imagen será redimensionada</b></br></div>';

        $archivo = 'image/'.$archivo;
        $array_medidas_img = redimensionar($archivo, 1123);
        echo '<img src="'.$archivo.'" width="'.$array_medidas_img[0].'" height="'.$array_medidas_img[1].'" />';

     }
     else {
        //Si la imagen es correcta en tamaño y tipo
        //Se intenta subir al servidor
        if (move_uploaded_file($temp, 'image/'.$archivo)) {
            //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
            chmod('image/'.$archivo, 0777);
            //Mostramos el mensaje de que se ha subido co éxito
            echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
            //Mostramos la imagen subida
            echo '<p><img src="image/'.$archivo.'"></p>';
        }
        else {
           //Si no se ha podido subir la imagen, mostramos un mensaje de error
           echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
        }
      }
   }
   else {
    echo 'Debe subir un archivo de imagen';
   }
}
?>
</div>
</body>
</html>