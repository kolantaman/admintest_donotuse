<?php
//echo "hello";
//error_reporting(0);
error_reporting(E_ALL);

// Configuration
include_once ("../_cd/config.php");
include_once ("_functions.php");

if(@$_POST['submit'] == "yes")
  {
  //echo "<br>POST baseslide: " . $_POST['baseslide'] . "<br>";

  //$baseslide = $_POST['baseslide'];
  $this_imagename = $_POST['filename'];
  $rawimage = $_FILES['baseslide']['tmp_name'];

//echo "<br>Vardump FILES<br>";
//var_dump($_FILES);


//echo "<br>Rawimage: " . $rawimage;

  if ($rawimage != "none" AND $rawimage != "")
    {
    // Das übergebene Bild wird geöffnet
    $new_image = imagecreatefromjpeg($rawimage);
    $dimensions = getimagesize($rawimage);
    $raw_width=$dimensions[0];
    $raw_height=$dimensions[1];


    // Großes Bild erzeugen
    //$resolution = "1600";
    $downloadbigimages = "../images/";
    //$bigimages_width = 1600;
    $bigimages_height = "auto";
    $hexbg = "#000000";

    $arr_res = array("770", "1200", "1400", "1600");

    foreach($arr_res AS $this_res)
      {
      $resolution = $this_res;
      $bigimages_width = $this_res;

    bigpic($rawimage, $this_imagename, $resolution, $downloadbigimages, $bigimages_width, $bigimages_height, $hexbg);
      }

  }  // if_submit eof

  }


//echo "<br>Hello again";



?>

<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">

<title>Responsive Slides</title>
<base target="_self">
<link rel='stylesheet' type='text/css' href='style.css'>

<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
</head>

<body style="background:#f7f7f7;margin:0;padding:0;">

<form method="POST" enctype='multipart/form-data'>
<table>
  <tr>
    <td>Filename Base: <input type="text" name="filename"></td>
  </tr>
  <tr>
    <td><input type="file" name="baseslide"></td>
  </tr>
  <tr>
    <td><button type="submit" name="submit" value="yes">Do it!</button></td>
  </tr>
</table>
</form>

<?php
?>

<?php include "adm_footer.php"; ?>

<script>
function change(){
    document.getElementById("adminchoice").submit();
}

/*var selectcontent = document.getElementById("topmenu_selected").innerHTML;
var newselectcontent = "&crarr;&nbsp;" + selectcontent;
document.getElementById("topmenu_selected").innerHTML = newselectcontent;*/
/*document.getElementById("topmenu_selected").style = "font-weight:bold;color:#0f6f89;";*/
</script>




</body>
</html>

<?php

function bigpic($rawimage, $this_imagename, $resolution, $downloadbigimages, $bigimages_width, $bigimages_height, $hexbg)
     {
//echo "hello!";
    list($r, $g, $b) = sscanf($hexbg, "#%02x%02x%02x");
    //echo $r;

     // Hintergrundfarbe für BigImage
     $bimage_r = $r;
     $bimage_g = $g;
     $bimage_b = $b;

     // Das übergebene Bild wird geöffnet
     $new_image = imagecreatefromjpeg($rawimage);
     $dimensions = getimagesize($rawimage);
     $raw_width=$dimensions[0];
     $raw_height=$dimensions[1];

     // Bildbreite bzw. Bildhöhe festlegen
     $bildbreite = $bigimages_width;
     $bildhoehe = $bigimages_height;

     // automatic image height, 220422, bw
     if($bigimages_height == "auto")
       {
       $ratio = $raw_width / $bigimages_width;
       $bildhoehe = intval($raw_height / $ratio);
//echo "<br>xBildbreite: " . $bildbreite . ", Bildhoehe: " . $bildhoehe;
       }

     // automatic image width, 220422, bw
     if($bigimages_width == "auto")
       {
       $ratio = $raw_height / $bigimages_height;
       $bildbreite = intval($raw_width / $ratio);
//echo "<br>Bildbreite: " . $bildbreite . ", Bildhoehe: " . $bildhoehe;
       }

     // Wenn das Ursprungsbild von der Größe genau passt
        if ($raw_width == $bildbreite AND $raw_height == $bildhoehe)
          {
echo "<br><b>I AM RIGHT AS RAIN</b><br>";
          // Wenn das gewählte Bild von der Größe her bereits passt, wird dieses Script gewählt
          // Das übergebene Bild wird geöffnet
          $new_image = imagecreatefromjpeg($rawimage);
          $dimensions = getimagesize($rawimage);
          $raw_width=$dimensions[0];
          $raw_height=$dimensions[1];

          // Neues Bild mit gewünschter Größe erzeugen
          $resized_image = imagecreatetruecolor($bildbreite, $bildhoehe);
          $page_background    = ImageColorAllocate ($resized_image, $bimage_r, $bimage_g, $bimage_b);
          imagefill($resized_image,0,0,$page_background);

          imagecopy($resized_image, $new_image, 0, 0, 0, 0, $raw_width, $raw_height);

          // Bild wird als "bild_" + idx gespeichert
          $bild = $this_imagename . "_" . $resolution . ".jpg";
          imagejpeg($resized_image,$downloadbigimages . $bild);
          @chmod ($downloadbigimages . $bild, 0766);
          }


        // Wenn das Ursprungsbild kleiner als benötigt ist
        elseif ($raw_width<=$bildbreite OR $raw_height<=$bildhoehe)
          {
echo "<br><b>I AM TOO SMALL</b><br>";
          // Wenn das gewählte Bild KLEINER als das benötigte ist, wird dieses Script gewählt
          // Das übergebene Bild wird geöffnet
          $new_image = imagecreatefromjpeg($rawimage);
          $dimensions = getimagesize($rawimage);
          $raw_width=$dimensions[0];
          $raw_height=$dimensions[1];

          // Neues Bild mit gewünschter Größe erzeugen
  echo "<br>Bildbreite: " . $bildbreite . ", Bildhoehe: " . $bildhoehe;
          $resized_image = imagecreatetruecolor($bildbreite, $bildhoehe);
          $page_background    = ImageColorAllocate ($resized_image, $bimage_r, $bimage_g, $bimage_b);
          imagefill($resized_image,0,0,$page_background);


          // Wenn das Ursprungsbild in Höhe UND Breite kleiner als benötigt ist
          if ($raw_width<=$bildbreite AND $raw_height<=$bildhoehe)
            {
            $offset_h = ($bildbreite - $raw_width)/2;
            $offset_v = ($bildhoehe - $raw_height)/2;
            imagecopy($resized_image, $new_image, $offset_h, $offset_v, 0, 0, $raw_width, $raw_height);
            }
          // Wenn das Ursprungsbild in Höhe GRÖSSER und Breite KLEINER als benötigt ist
          elseif ($raw_width<=$bildbreite AND $raw_height>=$bildhoehe)
            {
            $factor = $raw_height / $bildhoehe;
            $resized_height = $bildhoehe;
            $resized_width = $raw_width / $factor;
            $offset_h = ($bildbreite - $resized_width)/2;
            $offset_v = 0;
            imagecopyresampled($resized_image, $new_image, $offset_h, $offset_v, 0, 0, $resized_width, $resized_height, $raw_width, $raw_height);
            }
          // Wenn das Ursprungsbild in Höhe KLEINER und Breite GRÖSSER als benötigt ist
          elseif ($raw_width>=$bildbreite AND $raw_height<=$bildhoehe)
            {
            $factor = $raw_width / $bildbreite;
            $resized_width = $bildbreite;
            $resized_height = $raw_height / $factor;
            $offset_h = 0;
            $offset_v = ($bildhoehe - $resized_height)/2;
            imagecopyresampled($resized_image, $new_image, $offset_h, $offset_v, 0, 0, $resized_width, $resized_height, $raw_width, $raw_height);
            }

          // Bild wird als "bild_" + idx gespeichert
          $bild = $this_imagename . "_" . $resolution . ".jpg";
          imagejpeg($resized_image,$downloadbigimages . $bild);
          @chmod ($downloadbigimages . $bild, 0766);

          }
        // ansonsten das Bild normal anpassen
        else
          {
//echo "<br><b>I AM NORMAL</b><br>";

echo "<br>Image created " . $this_imagename . "_" . $bigimages_width . "p ";

        // Wenn das gewählte Bild breiter UND höher als die gewünschte Größe ist, wird dieses Script gewählt
        // Das übergebene Bild wird geöffnet
        $new_image = imagecreatefromjpeg($rawimage);
        $dimensions = getimagesize($rawimage);
        $raw_width=$dimensions[0];
        $raw_height=$dimensions[1];

        // Neues Bild mit gewünschter Größe erzeugen
        $resized_image = imagecreatetruecolor($bildbreite, $bildhoehe);
        $page_background    = ImageColorAllocate ($resized_image, $bimage_r, $bimage_g, $bimage_b);
        imagefill($resized_image,0,0,$page_background);


        // Wenn das Ursprungsbild in HÖHER als breit ist
        if ($raw_height>$raw_width)
          {
          $factor = $raw_height / $bildhoehe;
          $resized_height = $bildhoehe;
          $resized_width = $raw_width / $factor;
          $offset_h = ($bildbreite - $resized_width)/2;
          $offset_v = 0;
          imagecopyresampled($resized_image, $new_image, $offset_h, $offset_v, 0, 0, $resized_width, $resized_height, $raw_width, $raw_height);
          }
        // Wenn das Ursprungsbild BREITER als hoch ist
        elseif ($raw_width>$raw_height)
          {
          $factor = $raw_width / $bildbreite;
          $resized_width = $bildbreite;
          $resized_height = $raw_height / $factor;
          $offset_h = 0;
          $offset_v = ($bildhoehe - $resized_height)/2;
          imagecopyresampled($resized_image, $new_image, $offset_h, $offset_v, 0, 0, $resized_width, $resized_height, $raw_width, $raw_height);
          }
        // Wenn das Ursprungsbild BREITER UND HÖHER ist
        else
          {
          $resized_width = $bildbreite;
          $resized_height = $bildhoehe;
          $offset_h = 0;
          $offset_v = 0;
          imagecopyresampled($resized_image, $new_image, $offset_h, $offset_v, 0, 0, $resized_width, $resized_height, $raw_width, $raw_height);
          }

        // Bild wird als "bild_" + idx gespeichert
        $bild = $this_imagename . "_" . $resolution . ".jpg";
        imagejpeg($resized_image,$downloadbigimages . $bild);
        @chmod ($downloadbigimages . $bild, 0766);
        }

     return $bild;
     }
?>
